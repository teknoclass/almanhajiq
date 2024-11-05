<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{Courses, UserCourse};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseFullSubscriptionsController extends Controller
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
        $course = Courses::find($request->course_id);
        $data['course_id'] = $request->course_id;
        $data['price'] =  $course->priceDetails->price??0;

        return view('front.payment-options.full-subscription', $data);
    }

    public function fullSubscribe(Request $request)
    {
        $course = Courses::find($request->id);

        if($request->payment_type == "gateway")
        {
            return $this->paymentGateway($request);
        }else{
            return $this->zainCash($request);
        }
    }

    public function paymentGateway(Request $request)
    {
        $course = Courses::find($request->id);

        $response = $this->paymentService->processPayment([
            "amount" => $course->priceDetails->price??0,
            "currency" => "IQD",
            "successUrl" => url('/user/full-subscribe-course-confirm')
        ]);  
     
        if(isset($response['data']['link']))
        {
            $paymentDetails = [
                "description" => 'اشتراك كلى فى الدورة',
                "orderId" => $response['data']['orderId'],
                "payment_id" => $response['data']['token'],
                "amount" => $course->priceDetails->price??0,
                "transactionable_type" => "App\\Models\\Courses",
                "transactionable_id" => $course->id,
                "brand" => "master",
                "transaction_id" => $response['data']['transactionId'],
                'course_id' => $course->id,
                "purchase_type" => $request->type
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
 
            return  $response = [
                'status_msg' => 'success',
                'status' => 200,
                'payment' => true,
                'redirect_url' => $response['data']['link']
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
        $course = Courses::find($request->id);

        $response = $this->zainCashService->processPayment($course->priceDetails->price??0,
        url('/user/full-subscribe-course-confirm'),"اشتراك كلى فى دورة"); 
        
        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => 'اشتراك كلى فى الدورة',
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $course->priceDetails->price??0,
                "transactionable_type" => "App\\Models\\Courses",
                "transactionable_id" => $course->id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $course->id,
                "purchase_type" => $request->type
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
 
            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            return  $response = [
                'status_msg' => 'success',
                'status' => 200,
                'payment' => true,
                'redirect_url' => $paymentUrl
            ];
        }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('message.unexpected_error'),
            ];
        } 
    }

    public function fullConfirmSubscribe()
    {
        DB::beginTransaction();
        try
        {
            $paymentDetails = session('payment-'.auth('web')->user()->id);
    
            //user course create
            UserCourse::create([
                "course_id" => $paymentDetails['course_id'],
                "user_id" => auth('web')->user()->id,
                "lecturer_id" => Courses::find($paymentDetails['course_id'])->user_id??"",
                "subscription_token"  => $paymentDetails['payment_id'],
                "is_paid" => 1,
                "is_complete_payment" => 1,
            ]);

            $this->paymentService->createTransactionRecord($paymentDetails);

            $this->paymentService->storeBalance($paymentDetails);
    
            session()->forget('payment-'.auth('web')->user()->id);
    
            $course_id = $paymentDetails['course_id'];
    
            DB::commit(); 
            return redirect("/user/courses/curriculum/item/".$course_id);
        }
        catch (\Exception $e)
        {
            DB::rollback(); 
            Log::error($e->getMessage());
            return redirect(url('/payment-failure')); 
        }
    }
 

}