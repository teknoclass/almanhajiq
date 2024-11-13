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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Models\CourseSessionInstallment;
use App\Http\Resources\ApiCourseResource;
use App\Models\CourseSessionSubscription;
use App\Models\StudentSessionInstallment;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiPaymentInstallmentsResource;
use App\Http\Resources\ApiPaymentInstallmentsTimesResource;

use function PHPUnit\Framework\returnSelf;

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
        $price = 0;
        if($course->priceDetails != null){
            if($course->priceDetails->discount_price != null){
                $price = $course->priceDetails->discount_price;
            }else{
                $price = $course->priceDetails->price;
            }
        }
        $response = $this->paymentService->processPaymentApi([
            "amount" => $price??0,
            "currency" => "IQD",
            "successUrl" => url('/api/payment/full-subscribe-course-confirm'),
            'orderId' => $orderId,
            'notificationUrl' => ''
        ]);
        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => 'اشتراك كلى فى الدورة',
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $course->getPriceForPayment(),
                "transactionable_type" => "App\\Models\\Courses",
                "transactionable_id" => $course->id,
                "brand" => "card",
                'course_id' => $course->id,
                "purchase_type" => $request->type,
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);



            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                ['course_details' => new ApiCourseResource($course)],
                ['payment_link' => [
                    'name' => 'iq',
                    'image' => url('/assets/front/images/qi-logo.png'),
                    'link' => $response['formUrl']
                ]]
            ],Response::HTTP_OK);

            return response()->success($response);


        }else{
            $response = new ErrorResponse($response['error'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    public function fullConfirmSubscribe(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
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
            return redirect('/payment-failure');
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
            "orderId" => $orderId,
            'notificationUrl' => ''
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

        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $request->price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "card",
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);


            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                ['course_details' => ['title' => $title]],
                ['payment_link' => [
                    'name' => 'iq',
                    'image' => 'https://almanhajiq.com/assets/front/images/qi-logo.png',
                    'link' => $response['formUrl']
                ]]
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            //return $response;
            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    public function confirmSubscribe(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
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
            $cartId = $request->get('requestId');
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
            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function buyFree(Request $request){
        $response = $this->paymentService->buyFree($request);

        if($response){
            $response = new SuccessResponse(__('message.operation_accomplished_successfully'),null,Response::HTTP_OK);
            return response()->success($response);
        }else{
            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

    }

    function paymentGateway(Request $request){

        $orderId = genereatePaymentOrderID();

        $installment = $this->getCurInstallmentPrice($request->course_id);

        if(!$installment){
            $response = new ErrorResponse(__('all_installments_have_been_paid'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $response = $this->paymentService->processPaymentApi([
            "amount" => $installment->price,
            "currency" => "IQD",
            "successUrl" => url('/api/payment/pay-to-course-session-installment-confirm'),
            "notificationUrl" => url('/api/payment/pay-to-course-session-installment-confirm'),
            'orderId' => $orderId
        ]);
        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => 1,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $installment->id,
                "brand" => "card",
                'course_id' => $request->course_id
            ];
            $this->paymentService->createTransactionRecordApi($paymentDetails);

            $course = Courses::find($request->course_id);
            $installmetns = $course->installments;

            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'course_details' => [
                    'course' => new ApiCourseResource($course),
                    'installments' => ApiPaymentInstallmentsResource::collection($installmetns),
                    'times' => ApiPaymentInstallmentsTimesResource::collection($installmetns)
                ],
                'price' => $installment->price,
                'payment_link' => [
                    'name' => 'iq',
                    'image' => url('/assets/front/images/qi-logo.png'),
                    'link' => $response['formUrl']
                ]
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['error'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function getCurInstallmentPrice($courseId){

        $last = StudentSessionInstallment::where('course_id',$courseId)->orderBy('access_until_session_id', 'desc')->first();
        if($last)$id = $last->access_until_session_id;
        else $id = 0;
        $installment = CourseSessionInstallment::where('course_id',$courseId)->where('course_session_id','>',$id)->first();
        return $installment;


    }

    function confirmPayment(Request $request){
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
            $paymentDetails = Transactios::where('order_id',$cartId)->first();
            $paymentDetails->status = 'completed';
            $paymentDetails->is_paid = 1;
            $paymentDetails->save();

            //check qi payment status
            $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

            if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
            {
                return redirect('/payment-failure');
            }

            $courseSession = CourseSessionInstallment::find($paymentDetails['transactionable_id']);
            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => $paymentDetails['user_id'],
                'course_id' => $courseSession->course_id,
                'access_until_session_id' => $courseSession->course_session_id
            ]);


            $this->paymentService->storeBalanceApi($paymentDetails,'installment');


            DB::commit();
            $response = new SuccessResponse(__('message.operation_accomplished_successfully'),null,Response::HTTP_OK);
            return response()->success($response);
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
