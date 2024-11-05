<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use \Firebase\JWT\JWT;

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
        $this->tUrl = env('ZAINCASH_TO_URL');
        $this->rUrl = env('ZAINCASH_REDIRECT_URL');
       
    }

    public function processPayment($amount, $redirectUrl, $service_type)
    {
        try {
        $orderId = genereatePaymentOrderID();
        $token = $this->generateToken($amount,$orderId,$redirectUrl,"book");

        //POSTing data to ZainCash API
        $data_to_post = array();
        $data_to_post['token'] = urlencode($token);
        $data_to_post['merchantId'] =  $this->merchantId ;
        $data_to_post['lang'] = app()->getLocale();
        $options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data_to_post),
        ),
        );
        $context  = stream_context_create($options);
        $response= file_get_contents($this->tUrl , false, $context);

        return json_decode($response, true);
        
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        } 
    }

    private function generateToken($amount,$orderId,$redirectUrl,$service_type)
    {
        $data = [
            'amount'  => $amount,        
            'serviceType'  => $service_type,          
            'msisdn'  => $this->msisdn, 
            'orderId'  => $orderId,
            'redirectUrl'  => $redirectUrl,
            'iat'  => time(),
            'exp'  => time()+60*60*4
        ];
        
        $token = JWT::encode(
            $data,    
            $this->secretKey ,'HS256' 
        );

        return $token;
    }
}
