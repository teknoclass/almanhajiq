<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{Courses, UserCourse,Coupons,Balances,Transactios,PaymentDetail,PrivateLessons};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;
use App\Repositories\Front\User\PrivateLessonsEloquent;

class PrivateLessonSubscriptionsController extends Controller
{

    protected PaymentService $paymentService;
    protected ZainCashService $zainCashService;

    public function __construct()
    {
       $this->paymentService = new PaymentService();
       $this->zainCashService = new ZainCashService();
    }

    public function pay(Request $request)
    {
        $transaction = Transactios::find($request->id);
        
        if($request->payment_type == "gateway")
        {
            return $this->paymentGateway($transaction);
        }else{
            return $this->zainCash($transaction);
        }
    }

    public function paymentGateway($transaction)
    {
        $response = $this->paymentService->processPayment([
            "amount" => $transaction->amount,
            "currency" => "IQD",
            "finishPaymentUrl" => url('/user/private-lesson-confirm'),
            "notificationUrl" => url('/private-lesson-subscribe-webhook')
        ]);  
 
        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "transaction_id" => $transaction->id,
                "description" => $transaction->description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $transaction->amount,
                "transactionable_type" => $transaction->transactionable_type,
                "transactionable_id" => $transaction->transactionable_id,
                "brand" => "card",
                "user_id" => auth('web')->user()->id,
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
            storePaymentDetails($paymentDetails);
            
            return  $response = [
                'status_msg' => 'success',
                'status' => 200,
                'payment' => true,
                'payment_link' => $response['formUrl']
            ];
        }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('message.unexpected_error'),
            ];
        } 
    }
 
    public function zainCash($transaction)
    {
        $response = $this->zainCashService->processPayment($transaction->amount,
        url('/user/private-lesson-confirm'),$transaction->description); 
        
        if(isset($response['id']))
        {
            $paymentDetails = [
                "transaction_id" => $transaction->id,
                "description" => $transaction->description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $transaction->amount,
                "transactionable_type" => $transaction->transactionable_type,
                "transactionable_id" => $transaction->transactionable_id,
                "brand" => "zaincash",
                "user_id" => auth('web')->user()->id,
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
 
            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            return  $response = [
                'status_msg' => 'success',
                'status' => 200,
                'payment' => true,
                'payment_link' => $paymentUrl
            ];
        }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('message.unexpected_error'),
            ];
        } 
    }
    
    public function confirmPayment(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $paymentDetails = session('payment-'.auth('web')->user()->id);
            
            //check zain cash payment status
            if($paymentDetails["brand"] == "zaincash")
            {
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "zaincash" && $statusCheck["status"] != "completed")
                {
                    return redirect('/payment-failure'); 
                }
            }

            //check qi payment status
            $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);
    
            if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
            {
                return redirect('/payment-failure'); 
            }

            (new PrivateLessonsEloquent())->pay_realated($paymentDetails['transaction_id']);

            DB::commit(); 
            return redirect("/user/private-lessons");
        }
        catch (\Exception $e)
        {
            DB::rollback(); 
            Log::error($e->getMessage());
            Log::error($e->getFile());
            Log::error($e->getLine());
            return redirect('/payment-failure'); 
        }
    }

    public function handleWebhook(Request $request)
    {

    }

}