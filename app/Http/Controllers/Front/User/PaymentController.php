<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Models\Transactios;
use Illuminate\Http\Request;
use App\Repositories\Front\User\PaymentEloquent;

class PaymentController extends Controller
{
    private $payment;
    public function __construct(PaymentEloquent $payment_eloquent)
    {
        $this->payment = $payment_eloquent;
    }

    public function checkoutV0(Request $request, $action_type, $action_id)
    {
        if (!checkUser('student')) {
            $url_login=route('user.auth.login');
            return redirect()->to($url_login);
        }

        $data=$this->payment->checkoutV0($request, $action_type, $action_id);

        return view('front.user.payment.index', $data);
    }

    public function checkStatusV0(Request $request, $action_type, $action_id)
    {
        $data=$this->payment->checkStatus($request, $action_type, $action_id);


        $status='error';
        if ($data['status']) {
            $status='success';
        }

        return redirect()->to($data['redirect_url'])->with($status, $data['message']);
    }

    // --------------------------
    function checkout($transaction_id)
    {
        $transaction = Transactios::where('user_id' , auth('web')->id())->where('is_paid' , 0)->find($transaction_id);
        if(!$transaction){
            return redirect('/')->with('error' , 'You dont have payment now');
        }

        $currency = $user->country->currency_name ?? __('currency');
        $title = $this->get_title($transaction);
        // $stripe_key = env('stripe_key' , "pk_test_51HTpx3Azqp7r8Lno3MIZKFZs43xLCjYR4u7XVnKxNYQbGzQcUm3qtJNuJFrfT7X1RaV5Gci9mWCVEVuYfP4XiPRt00TrCFrYeB");
        return view('front.payment-options.private-lesson',compact('transaction' , 'title' , 'currency'));
    }

    function get_title($transaction) {
        $title = "";
        if($transaction->transactionable_type == 'App\Models\PrivateLessons')
        {
            $count_lessons = count($transaction->related_transactions);
            $count_lessons = $count_lessons ? $count_lessons : 1 ;
            $response  =  " ( $count_lessons ) " . __('Private_lesson') . ' - ';
            $response .=  __('lecturer') . ' ' . $transaction->transactionable?->teacher?->name;
            return $response;
        }

        if($transaction->transactionable_id){
            return $transaction->transactionable?->translations[0]?->title;
        }else{
            foreach ($transaction->related_transactions as $key => $related_transaction) {
                $title .= $key ? " & " : "";
                $title .= $related_transaction->transactionable?->translations[0]?->title;
            }
            return $title;
        }
    }

    function init(Request $request)
    {
        $init_response =  $this->payment->init($request);
        return response()->json(@$init_response['data'] ?? [] , @$init_response['status'] ?? 200);
    }

    public function checkStatus(Request $request , $payment_id)
    {
        $checkStatus_response =  $this->payment->checkStatus($request , $payment_id);
        return redirect(@$checkStatus_response['redirect_url'] ?? '/')->with(@$checkStatus_response['message'] ?? __("لم يتم الاشتراك"));
    }

}
