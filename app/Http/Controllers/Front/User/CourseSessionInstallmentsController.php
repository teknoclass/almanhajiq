<?php

namespace App\Http\Controllers\Front\User;

use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Repositories\Common\CourseCurriculumEloquent;
use App\Models\{StudentSessionInstallment,CourseSession};
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\CourseSessionInstallment;
use App\Models\Courses;

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
        $installment = CourseSessionInstallment::where('course_session_id',$request->id)->where('course_id',$request->course_id)->first();
        if(! $installment)
        {
            return back();
        }
        $data['price'] = $installment->price ?? 0;

        //if free
        if($installment->price == 0 ||  $installment->price == "")
        {
            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => auth('web')->user()->id,
                'course_id' => $request->course_id,
                'access_until_session_id' => $request->id,
            ]);

            return redirect("/user/courses/curriculum/item/".$request->course_id);
        }

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
        $installment = CourseSessionInstallment::where('course_session_id',$request->id)->where('course_id',$request->course_id)->first();
        if(! $installment)
        {
            return back();
        }
        $price = $installment->price ?? 0;

       $response = $this->paymentService->processPayment([
            "amount" => $price,
            "currency" => "IQD",
            "finishPaymentUrl" => url('/user/pay-to-course-session-installment-confirm'),
            "notificationUrl" => url('/user/pay-to-course-session-installment-confirm'),
        ]);

        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $request->id,
                "brand" => "card",
                'course_id' => $request->course_id
            ];

            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);

            return  $response = [
                'status_msg' => 'success',
                'payment_link' => $response['formUrl']
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
        $installment = CourseSessionInstallment::where('course_session_id',$request->id)->where('course_id',$request->course_id)->first();
        if(! $installment)
        {
            return back();
        }
        $price = $installment->price ?? 0;

        $response = $this->zainCashService->processPayment($price,
        url('/user/pay-to-course-session-installment-confirm'),"دفع قسط جلسات دورة");

        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $price,
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

            //check zain cash payment status
            $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);

            if($paymentDetails["brand"] == "zaincash" && $statusCheck["status"] != "completed")
            {
                return redirect('/payment-failure');
            }

            //check qi payment status
            $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

            if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
            {
                return redirect('/payment-failure');
            }

            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => auth('web')->user()->id,
                'course_id' => $paymentDetails['course_id'],
                'access_until_session_id' => $paymentDetails['transactionable_id'],
            ]);

            UserCourse::create([
                "course_id" => $paymentDetails['course_id'],
                "user_id" => auth('web')->user()->id,
                "lecturer_id" => Courses::find($paymentDetails['course_id'])->user_id,
                "subscription_token"  => $paymentDetails['payment_id'],
                "is_paid" => 1,
                "is_complete_payment" => 1,
                'is_installment' => 1
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
            Log::error($e->getFile());
            Log::error($e->getLine());
            return redirect('/payment-failure');
        }
    }

}
