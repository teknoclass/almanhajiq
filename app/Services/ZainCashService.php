<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ZainCashService
{
    protected $client;
    protected $merchantId;
    protected $msisdn;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->merchantId = env('ZAINCASH_MERCHANT_ID');
        $this->msisdn = env('ZAINCASH_MSISDN');
        $this->secretKey = env('ZAINCASH_SECRET_KEY');
        $this->baseUrl = env('ZAINCASH_BASE_URL');
    }

    public function generatePaymentUrl($amount, $orderId, $redirectUrl)
    {
        $token = $this->generateToken();

        $data = [
            'msisdn' => $this->msisdn,
            'amount' => $amount,
            'orderid' => $orderId,
            'redirecturl' => $redirectUrl,
            'token' => $token,
        ];

        try {
            $response = $this->client->post("{$this->baseUrl}/checkout", [
                'json' => $data,
            ]);

            $result = json_decode($response->getBody(), true);

            return $result['payment_url'] ?? null;
        } catch (\Exception $e) {
            Log::error("Zain Cash Payment URL Generation Failed: " . $e->getMessage());
            return null;
        }
    }

    private function generateToken()
    {
        $payload = [
            'amount' => 'the amount',
            'msisdn' => $this->msisdn,
            'orderid' => 'your_order_id',
            'redirecturl' => 'your_redirect_url'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->secretKey);

        return base64_encode(json_encode([
            'payload' => $payload,
            'signature' => $signature,
        ]));
    }
}
