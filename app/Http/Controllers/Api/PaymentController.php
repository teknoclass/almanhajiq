<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Courses;
use App\Models\UserCourse;
use App\Models\Transactios;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSessionsGroup;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Http\Resources\ApiCourseResource;
use App\Models\CourseSessionSubscription;
use App\Models\StudentSessionInstallment;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function fullSubscribe(Request $request)
    {

        $course = Courses::find($request->id);
        $orderId = genereatePaymentOrderID();
        $response = $this->paymentService->processPaymentApi([
            "amount" => $course->priceDetails->price??0,
            "currency" => "IQD",
            "successUrl" => url('/api/payment/full-subscribe-course-confirm'),
            'orderId' => $orderId
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
                "purchase_type" => $request->type,
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);



            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                ['course_details' => new ApiCourseResource($course)],
                ['payment_link' => [
                    'name' => 'iq',
                    'image' => imageUrl('visa.png'),
                    'link' => $response['data']['link']
                ]]
            ],Response::HTTP_OK);

            return response()->success($response);


        }else{

            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    public function fullConfirmSubscribe(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('CartID');
            $paymentDetails = Transactios::where('order_id',$cartId)->first();
            $paymentDetails->status = 'completed';
            $paymentDetails->is_paid = 1;
            $paymentDetails->save();
            //user course create
            UserCourse::create([
                "course_id" => $paymentDetails['transactionable_id'],
                "user_id" => $paymentDetails['user_id'],
                "lecturer_id" => Courses::find($paymentDetails['transactionable_id'])->user_id,
                "subscription_token"  => $paymentDetails['payment_id'],
                "is_paid" => 1,
                "is_complete_payment" => 1,
            ]);


            $this->paymentService->storeBalanceApi($paymentDetails);


            DB::commit();
            $response = new SuccessResponse(__('message.operation_accomplished_successfully'),null,Response::HTTP_OK);
            return response()->success($response);
        } catch (\Exception $e)
        {
            DB::rollback();
            $response = new ErrorResponse($e->getMessage(),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }



    public function subscribe(Request $request)
    {

        if($request->type == "group"){
            $redirect = url('/api/payment/subscribe-to-course-group-confirm');
        }else{
            $redirect = url('/api/payment/subscribe-to-course-sessions-confirm');
        }
        $orderId = genereatePaymentOrderID();


        $response = $this->paymentService->processPaymentApi([
            "amount" => $request->price,
            "currency" => "IQD",
            "successUrl" => $redirect,
            "orderId" => $orderId
        ]);

        if($request->type == "group")
        {
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
            $title = CourseSessionsGroup::find($request->target_id)->title??"";

        }else{
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
            $title = CourseSession::find($request->target_id)->title??"";
        }

        if(isset($response['data']['link']))
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['data']['orderId'],
                "payment_id" => $response['data']['token'],
                "amount" => $request->price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "master",
                "transaction_id" => $response['data']['transactionId'],
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);


            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                ['course_details' => ['title' => $title]],
                ['payment_link' => [
                    'name' => 'iq',
                    'image' => imageUrl('visa.png'),
                    'link' => $response['data']['link']
                ]]
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    public function confirmSubscribe(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('CartID');
            $paymentDetails = Transactios::where('order_id',$cartId)->first();
            $paymentDetails->status = 'completed';
            $paymentDetails->is_paid = 1;
            $paymentDetails->save();

            $user = User::find($paymentDetails['user_id']);

            $studentSubscribedSessionsIds = $user->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            $session = CourseSession::find($paymentDetails['transactionable_id']);

            if(! in_array($session->id, $studentSubscribedSessionsIds))
            {
                CourseSessionSubscription::create([
                    'student_id' => $paymentDetails['user_id'],
                    'course_session_id' => $session->id,
                    'status' => 1,
                    'subscription_date' => now(),
                    'course_session_group_id' => $session->group_id,
                    'related_to_group_subscription' => 0,
                    'course_id' => $session->course_id
                ]);
            }



            $this->paymentService->storeBalanceApi($paymentDetails,'session');



            DB::commit();

            $response = new SuccessResponse(__('message.operation_accomplished_successfully'),null,Response::HTTP_OK);
            return response()->success($response);

        } catch (\Exception $e)
        {
            DB::rollback();
            $response = new ErrorResponse($e->getMessage(),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }


    public function confirmSubscribeGroup(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('CartID');
            $paymentDetails = Transactios::where('order_id',$cartId)->first();
            $paymentDetails->status = 'completed';
            $paymentDetails->is_paid = 1;
            $paymentDetails->save();

            $user = User::find($paymentDetails['user_id']);

            $studentSubscribedSessionsIds = $user->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            $sessions = CourseSession::where('group_id', $paymentDetails['transactionable_id'])->get();

            foreach($sessions as $session)
            {
                    if(! in_array( $session->id,$studentSubscribedSessionsIds))
                    {
                        CourseSessionSubscription::create([
                            'student_id' => $paymentDetails['user_id'],
                            'course_session_id' => $session->id,
                            'status' => 1,
                            'subscription_date' => now(),
                            'course_session_group_id' => $session->group_id,
                            'related_to_group_subscription' => 1,
                            'course_id' => $session->course_id
                        ]);
                    }
            }


            $this->paymentService->storeBalanceApi($paymentDetails,'group');



            DB::commit();

            $response = new SuccessResponse(__('message.operation_accomplished_successfully'),null,Response::HTTP_OK);
            return response()->success($response);

        } catch (\Exception $e)
        {
            DB::rollback();
            $response = new ErrorResponse($e->getMessage(),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
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

            return redirect("/user/courses/curriculum/item/".$course_id);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect('/payment-failure');
        }
    }




}
