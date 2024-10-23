<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCallBackController extends Controller
{

    public function paymentFailure()
    {
        return view('front.payment.payment-failure');
    }

    public function paymentCancelled()
    {
        return view('front.payment.payment-cancelled');
    }

    public function paymentWebhook()
    {
       
    }

}