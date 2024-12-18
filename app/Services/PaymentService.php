<?php
namespace App\Services;

use App\Models\UserCourse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\{Transactios,Balances, Courses, CourseSession, CourseSessionInstallment};

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
                'withoutAuthenticate' => true,
                'amount' => $paymentDetails['amount'],
                'currency' => $paymentDetails['currency'],
                'locale' => app()->getLocale(),
                'timestamp' => now()->toIso8601String(),
                'finishPaymentUrl' => $paymentDetails['finishPaymentUrl'],
                'notificationUrl' => $paymentDetails['notificationUrl'],
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
                'withoutAuthenticate' => true,
                'amount' => $paymentDetails['amount'],
                'currency' => $paymentDetails['currency'],
                'locale' => app()->getLocale(),
                'timestamp' => now()->toIso8601String(),
                'finishPaymentUrl' => $paymentDetails['successUrl'],
                'notificationUrl' => $paymentDetails['notificationUrl'],
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
        ],[
            'description' => $paymentDetails['description'],
            'user_id' => isset($paymentDetails['user_id']) ? $paymentDetails['user_id'] : auth('web')->id(),
            'user_type' => 'student',
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'type' => isset($paymentDetails['type']) ? $paymentDetails['type'] : 'deposit',
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
        Transactios::updateOrCreate([
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'transactionable_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transactionable_id' => $paymentDetails['transactionable_id'] ?? null,
        ],[
            'description' => $paymentDetails['description'],
            'user_id' => auth('api')->id(),
            'user_type' => 'student',
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'type' => 'deposit',
            'status' => 'pinding',
            'brand' => $paymentDetails['brand'] ?? null,
            'coupon' => $paymentDetails['coupon'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'is_paid' => false,
            'order_id' => $paymentDetails['orderId']
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
                'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
                'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
                'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
                'user_type' => 'lecturer',
                'user_id' => $lecturer->id,
            ],[
                'description' => $paymentDetails['description'],
                'type' => 'deposit',
                'is_retractable' => 1,
                'becomes_retractable_at' => now(),
                'system_commission' => $system_commission,
                'amount' => $amount,
                'amount_before_commission' => $amount_before_commission,
            ]);
        }
    }

    public function storeBalanceApi($paymentDetails , $type = 'course')
    {
        $lecturer = $this->getLecturer($type , $paymentDetails['transactionable_id']);

        $amount_before_commission = $paymentDetails['amount'];
        $system_commission = ($lecturer->system_commission ?? 0 > 0) ? ($lecturer->system_commission/100)*$amount_before_commission : 0;
        $amount = $amount_before_commission - $system_commission;

        Balances::updateOrCreate([
            'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'user_type' => 'lecturer',
            'user_id' => $lecturer->id ?? null,
        ],
        [
            'description' => $paymentDetails['description'],
            'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'type' => 'deposit',
            'is_retractable' => 1,
            'becomes_retractable_at' => now(),
            'system_commission' => $system_commission,
            'amount' => $amount,
            'amount_before_commission' => $amount_before_commission,
        ]);
    }

    function getLecturer($type , $id){

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
        }


    }


    function buyFree($request){

        $courseId = $request->get('course_id');

        $course = Courses::find($courseId);

        if($course->isFree()){
            UserCourse::create([
                "course_id"           => $request->get('course_id'),
                "user_id"             => auth('api')->id(),
                "lecturer_id"         => Courses::find($request->get('course_id'))->user_id,
                "is_paid"             => 1,
                "is_complete_payment" => 1,
            ]);

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
