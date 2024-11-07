<?php
namespace App\Services;

use App\Models\{Transactios,Balances, Courses, CourseSession};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('PAYMENT_API_URL');
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

            $payload = [
                'order' => [
                    'amount' => $paymentDetails['amount'],
                    'currency' => $paymentDetails['currency'],
                    'orderId' => genereatePaymentOrderID(),
                ],
                'timestamp' => now()->toIso8601String(),
                'successUrl' => $paymentDetails['successUrl'],
                'failureUrl' => url('/payment-failure'),
                'cancelUrl' => url('/payment-cancelled'),
                'webhookUrl' => url('/payment-webhook'),
            ];

            $response = Http::withHeaders([
                'Authorization' =>  $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $payload);

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
    public function processPaymentApi(array $paymentDetails): array
    {
        try {

            $payload = [
                'order' => [
                    'amount' => $paymentDetails['amount'],
                    'currency' => $paymentDetails['currency'],
                    'orderId' => $paymentDetails['orderId'],
                ],
                'timestamp' => now()->toIso8601String(),
                'successUrl' => $paymentDetails['successUrl'],
                'failureUrl' => url('/payment-failure'),
                'cancelUrl' => url('/payment-cancelled'),
                'webhookUrl' => url('/payment-webhook'),
            ];

            $response = Http::withHeaders([
                'Authorization' =>  $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $payload);

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

    public function createTransactionRecord(array $paymentDetails)
    {
        Transactios::create([
            'description' => $paymentDetails['description'],
            'user_id' => auth('web')->id(),
            'user_type' => 'student',
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'type' => 'deposit',
            'status' => 'completed',
            'transactionable_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transactionable_id' => $paymentDetails['transactionable_id'] ?? null,
            'brand' => $paymentDetails['brand'] ?? null,
            'coupon' => $paymentDetails['coupon'] ?? null,
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'is_paid' => true,
            'order_id' => $paymentDetails['orderId']
        ]);
    }
    public function createTransactionRecordApi(array $paymentDetails)
    {
        Transactios::create([
            'description' => $paymentDetails['description'],
            'user_id' => auth('api')->id(),
            'user_type' => 'student',
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'amount' => $paymentDetails['amount'],
            'amount_before_discount' => $paymentDetails['amount'],
            'type' => 'deposit',
            'status' => 'pinding',
            'transactionable_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transactionable_id' => $paymentDetails['transactionable_id'] ?? null,
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
        $lecturer = $course->lecturer;

        $amount_before_commission = $paymentDetails['amount'];
        $system_commission = ($lecturer->system_commission > 0) ? ($lecturer->system_commission/100)*$amount_before_commission : 0;
        $amount = $amount_before_commission - $system_commission;

        Balances::create([
            'description' => $paymentDetails['description'],
            'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
            'type' => 'deposit',
            'is_retractable' => 1,
            'becomes_retractable_at' => now(),
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'user_type' => 'lecturer',
            'user_id' => $lecturer->id,
            'system_commission' => $system_commission,
            'amount' => $amount,
            'amount_before_commission' => $amount_before_commission,
        ]);
    }
    public function storeBalanceApi($paymentDetails , $type = 'course')
    {
        $lecturer = $this->getLecturer($type , $paymentDetails['transactionable_id']);

        $amount_before_commission = $paymentDetails['amount'];
        $system_commission = ($lecturer->system_commission ?? 0 > 0) ? ($lecturer->system_commission/100)*$amount_before_commission : 0;
        $amount = $amount_before_commission - $system_commission;

        Balances::create([
            'description' => $paymentDetails['description'],
            'transaction_type' => $paymentDetails['transactionable_type'] ?? 'Order',
            'transaction_id' => $paymentDetails['transactionable_id'] ?? null,
            'type' => 'deposit',
            'is_retractable' => 1,
            'becomes_retractable_at' => now(),
            'pay_transaction_id' => $paymentDetails['transaction_id'] ?? null,
            'user_type' => 'lecturer',
            'user_id' => $lecturer->id ?? null,
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
        }


    }

}
