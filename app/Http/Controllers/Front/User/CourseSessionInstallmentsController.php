<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{StudentSessionInstallment,CourseSession};
use App\Services\PaymentService;

class CourseSessionInstallmentsController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct()
    {
       $this->paymentService = new PaymentService();
    }

    public function pay(Request $request)
    {
       $response = $this->paymentService->processPayment([
            "amount" => $request->price,
            "currency" => "IQD",
            "successUrl" => url('/user/pay-to-course-session-installment-confirm')
        ]);  
        
        if(isset($response['data']['link']))
        {
            $paymentDetails = [
                "orderId" => $response['data']['orderId'],
                "payment_id" => $response['data']['token'],
                "amount" => $request->price,
                "transactionable_type" => "App\Models\\StudentSessionInstallment",
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

    public function confirmPayment(Request $request)
    {
        $paymentDetails = session('payment-'.auth('web')->user()->id);

        $item = StudentSessionInstallment::updateOrCreate([
            'student_id' => auth('web')->user()->id,
            'course_id' => $paymentDetails['course_id'],
            'access_until_session_id' => $paymentDetails['transactionable_id'],
        ]);

        $this->paymentService->createTransactionRecord($paymentDetails);

        session()->forget('payment-'.auth('web')->user()->id);

        $course_id = $paymentDetails['course_id'];

        return redirect(url("/user/courses/curriculum/item/".$course_id));
    }

}