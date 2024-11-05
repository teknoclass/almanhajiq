<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{StudentSessionInstallment,CourseSession};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseSessionInstallmentsController extends Controller
{
    protected PaymentService $paymentService;
    protected ZainCashService $zainCashService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->zainCashService = new ZainCashService();
    }

    public function selectPaymentMethod(Request $request)
    {
        $data['course_id'] = $request->course_id;
        $data['id'] = $request->id;
        $data['price'] = $request->price;

        return view('front.payment-options.installment-subscription', $data);
    }

    public function pay(Request $request)
    {
        if($request->payment_type == "gateway")
        {
            return $this->paymentGateway($request);
        }else{
            return $this->zainCash($request);
        }
    }

    public function paymentGateway(Request $request)
    {
       $response = $this->paymentService->processPayment([
            "amount" => $request->price,
            "currency" => "IQD",
            "successUrl" => url('/user/pay-to-course-session-installment-confirm')
        ]);  
        
        if(isset($response['data']['link']))
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['data']['orderId'],
                "payment_id" => $response['data']['token'],
                "amount" => $request->price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $request->id,
                "brand" => "master",
                "transaction_id" => $response['data']['transactionId'],
                'course_id' => $request->course_id
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);

            return  $response = [
                'status_msg' => 'success',
                'payment_link' => $response['data']['link']
            ];
        }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('message.unexpected_error'),
            ];
        }  
    }

    public function zainCash(Request $request)
    {
        $response = $this->zainCashService->processPayment($request->price,
        url('/user/pay-to-course-session-installment-confirm'),"دفع قسط جلسات دورة");  
        
        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $request->price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $request->id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $request->course_id
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);

            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            return  $response = [
                'status_msg' => 'success',
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

            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => auth('web')->user()->id,
                'course_id' => $paymentDetails['course_id'],
                'access_until_session_id' => $paymentDetails['transactionable_id'],
            ]);

            $this->paymentService->createTransactionRecord($paymentDetails);

            $this->paymentService->storeBalance($paymentDetails);

            session()->forget('payment-'.auth('web')->user()->id);

            $course_id = $paymentDetails['course_id'];

            DB::commit(); 

            return redirect(url("/user/courses/curriculum/item/".$course_id));
        } catch (\Exception $e)
        {
            DB::rollback(); 
            Log::error($e->getMessage());
            return redirect(url('/payment-failure')); 
        }
    }

}