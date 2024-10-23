<?php
namespace App\Services;

use App\Models\{Transactios};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.payment.api_url');
        $this->apiKey = config('services.payment.api_key');
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
                'Authorization' =>  '39cd434c94fa49e99646b58f31bbdb88',
                'Content-Type' => 'application/json',
            ])->post('https://api.uat.pay.qi.iq/api/v0/transactions/business/token', $payload);

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
        ]);
    }
}