<?php
namespace App\Services;

use App\Models\UserCourse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\{Transactios,Balances, Courses, CourseSession, CourseSessionInstallment, User};

class PaymentService
{
    private $apiUrl;
    private $paymentUserName;
    private $paymentPassword;
    private $paymentTerminalID;
    private $apiUrl2;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('PAYMENT_API_URL');
        $this->paymentUserName = env('PAYMENT_API_USERNAME');
        $this->paymentPassword = env('PAYMENT_API_PASSWORD');
        $this->paymentTerminalID = env('PAYMENT_API_TERMINAL_ID');

        $this->apiUrl2 = env('PAYMENT_API_URL2');
        $this->apiKey = env('PAYMENT_API_KEY');
    }

    /**
     * Process the payment by sending a request to the payment provider.
     *
     * @param array $paymentDetails
     * @return array
     */
    public function processPayment(array $paymentDetails): array
    {
        try {

            $auth = base64_encode("{$this->paymentUserName}:{$this->paymentPassword}");

            $payload = [
                'requestId' => genereatePaymentOrderID(),
                'withoutAuthenticate' => (env('APP_ENV') != 'local') ? false : true,
                'amount' => $paymentDetails['amount'],
                'currency' => $paymentDetails['currency'],
                'locale' => app()->getLocale(),
                'timestamp' => now()->toIso8601String(),
                'finishPaymentUrl' => url('/user/confirm-payment'),
                'notificationUrl' =>  url('/payment-webhook'),
                'customerInfo' => [
                    "firstName" => auth('web')->user()->name,
                    "phone" => auth('web')->user()->mobile,
                    "email" => auth('web')->user()->email
                ]
            ];



            $response = Http::withHeaders([
                'Authorization' => "Basic {$auth}",
                'X-Terminal-Id' => $this->paymentTerminalID,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/payment", $payload);

            if ($response->successful()) {
                $paymentResponse = $response->json();

                return $paymentResponse;
            } else {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getLine());
            Log::error($e->getFile());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     *
     * @param string $paymentId
    */
    public function checkPaymentStatus($paymentId)
    {
        try{

            $auth = base64_encode("{$this->paymentUserName}:{$this->paymentPassword}");

            $response = Http::withHeaders([
                'Authorization' => "Basic {$auth}",
                'X-Terminal-Id' => $this->paymentTerminalID,
                'Content-Type' => 'application/json',
            ])->get("{$this->apiUrl}/payment/{$paymentId}/status");

            if ($response->successful()) {
                $statusResponse = $response->json();

                return $statusResponse;
            } else {
                return $response->json();
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function processPaymentApi(array $paymentDetails): array
    {
        try {

            $auth = base64_encode("{$this->paymentUserName}:{$this->paymentPassword}");

            $payload = [
                'requestId' => $paymentDetails['orderId'],
                'withoutAuthenticate' => (env('APP_ENV') != 'local') ? false : true,
                'amount' => $paymentDetails['amount'],
                'currency' => $paymentDetails['currency'],
                'locale' => app()->getLocale(),
                'timestamp' => now()->toIso8601String(),
                'customerInfo' => [
                    "firstName" => auth('api')->user()->name,
                    "phone" => auth('api')->user()->mobile,
                    "email" => auth('api')->user()->email
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => "Basic {$auth}",
                'X-Terminal-Id' => $this->paymentTerminalID,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/payment", $payload);

            if ($response->successful()) {
                $paymentResponse = $response->json();

                return $paymentResponse;
            } else {
                return $response->json();
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(),
        'status' => "FAILED"];
        }
    }

    public function createTransactionRecord(array $paymentDetails)
    {
        Transactios::updateOrCreate([
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'transactionable_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transactionable_id' => $paymentDetails['transactionable_id'] ?? null,
            'type' => isset($paymentDetails['type']) ? $paymentDetails['type'] : 'deposit',
        ],[
            'description' => $paymentDetails['description'],
            'user_id' => isset($paymentDetails['user_id']) ? $paymentDetails['user_id'] : auth('web')->id(),
            'user_type' => 'student',
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'status' => 'completed',
            'brand' => $paymentDetails['brand'] ?? null,
            'coupon' => $paymentDetails['marketer_coupon'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'is_paid' => true,
            'order_id' => $paymentDetails['orderId'],
            'refund_id' => isset($paymentDetails['refund_id']) ? $paymentDetails['refund_id'] : '',
            'is_refunded' => isset($paymentDetails['is_refunded']) ? $paymentDetails['is_refunded'] : 0,
        ]);
    }

    public function createTransactionRecordApi(array $paymentDetails)
    {
        if(array_key_exists('status', $paymentDetails)){
            $status = $paymentDetails['status'];
        }else{
            $status = 'pinding';
        }

        Transactios::updateOrCreate([
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'transactionable_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transactionable_id' => $paymentDetails['transactionable_id'] ?? null,
            'type' => 'deposit',
        ],[
            'description' => $paymentDetails['description'],
            'user_id' => auth('api')->id(),
            'user_type' => 'student',
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'status' => $status,
            'brand' => $paymentDetails['brand'] ?? null,
            'coupon' => $paymentDetails['coupon'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'is_paid' => false,
            'order_id' => $paymentDetails['orderId'] ?? null,
            'place' => 'api',
            'payment_type' => $paymentDetails['payment_type'] ?? null
        ]);
    }

    public function storeBalance(array $paymentDetails)
    {
        $course = Courses::find($paymentDetails['course_id']);
        $lecturer = @$course->lecturer;
        if($lecturer)
        {
            $amount_before_commission = $paymentDetails['amount'];
            $system_commission = ($lecturer->system_commission > 0) ? ($lecturer->system_commission/100)*$amount_before_commission : $amount_before_commission / 2;
            $amount = $amount_before_commission - $system_commission;

            Balances::updateOrCreate([
                'payment_id' => $paymentDetails['payment_id'] ?? null,
                'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
                'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
                'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
                'user_type' => 'lecturer',
                'user_id' => $lecturer->id,
                'type' => isset($paymentDetails['type']) ? $paymentDetails['type'] : "deposit",
            ],[
                'description' => $paymentDetails['description'],
                'is_retractable' => 1,
                'becomes_retractable_at' => now(),
                'system_commission' => $system_commission,
                'amount' => $amount,
                'amount_before_commission' => $amount_before_commission,
            ]);
        }
    }

    public function storeBalanceApi($paymentDetails , $type = 'course',$id = 0)
    {
        $lecturer = $this->getLecturer($type , $paymentDetails['transactionable_id'],$id);

        $amount_before_commission = $paymentDetails['amount'];
        $system_commission = ($lecturer->system_commission ?? 0 > 0) ? ($lecturer->system_commission/100)*$amount_before_commission : 0;
        $amount = $amount_before_commission - $system_commission;

        Balances::updateOrCreate([
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'user_type' => 'lecturer',
            'user_id' => $lecturer->id ?? null,
            'type' => 'deposit',
        ],
        [
            'description' => $paymentDetails['description'],
            'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'is_retractable' => 1,
            'becomes_retractable_at' => now(),
            'system_commission' => $system_commission,
            'amount' => $amount,
            'amount_before_commission' => $amount_before_commission,
        ]);
    }

    function getLecturer($type , $id , $id2){

        switch($type){
            case 'course' :

                $course = Courses::find($id);
                return $lecturer = $course->lecturer;
                break;

            case 'session' :
                $session = CourseSession::find($id);
                return $lecturer = $session->course->lecturer;
                break;

            case 'group' :
                $session = CourseSession::where('group_id',$id)->first();
                return $lecturer = $session->course->lecturer;
                break;

            case 'installment' :
                $installment = CourseSessionInstallment::find($id);
                return $installment->courseSession->course->lecturer;
                break;

            case 'private_lesson' :
                return User::find($id2);

        }


    }


    function buyFree($request){

        $courseId = $request->get('course_id');
        $coupon = $request->get('coupon');

        $course = Courses::find($courseId);

        if($course->isFree($coupon)){
            UserCourse::create([
                "course_id"           => $request->get('course_id'),
                "user_id"             => auth('api')->id(),
                "lecturer_id"         => Courses::find($request->get('course_id'))->user_id,
                "is_paid"             => 1,
                "is_complete_payment" => 1,
            ]);
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => null,
                "payment_id" => uniqid(),
                "amount" => 0,
                "transactionable_type" => "App\\Models\\Courses",
                "transactionable_id" => $course->id,
                "brand" => "free",
                'course_id' => $request->course_id,
                'coupon' => $request->get('coupon'),
                'payment_type' => 'free',
                'status' => 'completed'
            ]; 

            $this->createTransactionRecordApi($paymentDetails);

            return true;

        }else{
            return false;
        }


    }

    public function makeRefund($paymentId)
    {
        try{

            $auth = base64_encode("{$this->paymentUserName}:{$this->paymentPassword}");
            $payload = [
                'requestId' => genereatePaymentOrderID(),
                'message' => 'need cancel subscription'
            ];

            $response = Http::withHeaders([
                'Authorization' => "Basic {$auth}",
                'X-Terminal-Id' => $this->paymentTerminalID,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/payment/{$paymentId}/refund", $payload);

            if ($response->successful()) {
                $statusResponse = $response->json();

                return $statusResponse;
            } else {
                return $response->json();
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
