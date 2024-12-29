<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;
use App\Models\Coupons;
use App\Models\Courses;
use App\Models\UserCourse;
use App\Models\Transactios;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSessionsGroup;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\freeInstallmentRequest;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Models\CourseSessionInstallment;
use App\Http\Resources\ApiCourseResource;
use App\Models\CourseSessionSubscription;
use App\Models\StudentSessionInstallment;
use function PHPUnit\Framework\returnSelf;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiPaymentInstallmentsResource;
use App\Http\Resources\ApiPaymentInstallmentsTimesResource;
use App\Models\PaymentDetail;
use App\Models\PrivateLessons;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    protected ZainCashService $zainCashService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->zainCashService = new ZainCashService();

    }

    function fullSubscribeDetails(Request $request){
        $course = Courses::find($request->id);
        $price = 0;
        if($course->priceDetails != null){
            if($course->priceDetails->discount_price != null){
                $price = $course->priceDetails->discount_price;
            }else{
                $price = $course->priceDetails->price;
            }
        }

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        if($price >= 250)$msg = '';
        else $msg = __('amount_must_exceed_1000_iqd');

        $paymentMethods = [
            [
                'name' => 'zain',
                'image' => url('/assets/front/images/zain-cash.png'),
                'message' => $msg
            ]
        ];
        if(getSeting('qi')){
            $paymentMethods[] = [
                'name' => 'gateway',
                'image' => url('/assets/front/images/qi-logo.png'),
                'message' => ''
            ];
        }


        $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
            'course_details' => new ApiCourseResource($course),
            'payment_methods' => $paymentMethods

        ],Response::HTTP_OK);

        return response()->success($response);



    }

    function fullSubscribe(Request $request){

        if($request->payment_type == "gateway")
        {
            return $this->fullSubscribeGateway($request);
        }else{
            return $this->fullSubscribeZain($request);
        }

    }



    public function fullSubscribeGateway($request)
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

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
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
                "purchase_type" => $request->payment_type,
                'coupon' => $request->get('code')
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);



            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $response['formUrl']
            ],Response::HTTP_OK);

            return response()->success($response);


        }else{
            $response = new ErrorResponse($response['error'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function fullSubscribeZain($request){
        $orderId = genereatePaymentOrderID();
        $course = Courses::find($request->id);
        $price = $course->getPriceForPayment();

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        $response = $this->zainCashService->processPaymentApi($price,
        url('/api/payment/full-subscribe-course-confirm'),"اشتراك كلى فى دورة",$orderId);

        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => 'اشتراك كلى فى الدورة',
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $course->getPriceForPayment(),
                "transactionable_type" => "App\\Models\\Courses",
                "transactionable_id" => $course->id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $course->id,
                "purchase_type" => $request->payment_type,
                'coupon' => $request->get('code')
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);

            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $paymentUrl
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{

            $response = new ErrorResponse($response['err']['msg'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

    }



    public function fullConfirmSubscribe(Request $request)
    {

        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
            $token = $request->get('token');
            if($cartId == null){
                $data = JWT::decode($token, new Key(env('ZAINCASH_SECRET_KEY'), 'HS256'));
                $cartId = $data->orderid;
            }
            $paymentDetails = Transactios::where('order_id',$cartId)->first();

            if($paymentDetails["brand"] == "card"){

                $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
                {
                    return redirect('/payment-failure');
                }
            }else{
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);
                if($statusCheck["status"] == "failed")
                {
                    return redirect('/payment-failure');
                }
            }

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


    function subscribeDetailsFree(Request $request)
    {
        $id   = $request->target_id ?? 0;
        $type = $request->type == "group" ? "group" : 'session';
        if($type == "group")
        {
            // $title = CourseSessionsGroup::find($request->target_id)->title ?? "";
            $model = CourseSessionsGroup::find($id);

        }else{
            $model = CourseSession::find($id);
        }
        if(!$model)
        {
            return $this->response_api('error' , __('validation.free_sesions_not_foud') );
        }

        if($model->price)
        {
            return $this->response_api('error' , $model->title . ' ' . __('not_free') );
        }

        $user = auth('api')->user();

        if($type == "group"){
            // if(request()->dd == 1){ $user->studentSubscribedSessions()->delete();}
            $studentSubscribedSessionsIds = $user->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            $sessions = CourseSession::where('group_id', $id)->get();
            // if(request()->dd == 'sess'){ dd($studentSubscribedSessionsIds , $sessions , $user->studentSubscribedSessions);}

            foreach($sessions as $session)
            {
                if(! in_array( $session->id,$studentSubscribedSessionsIds))
                {
                    CourseSessionSubscription::create([
                        'student_id'                    => $user->id,
                        'course_session_id'             => $session->id,
                        'course_session_group_id'       => $id,
                        'status'                        => 1,
                        'subscription_date'             => now(),
                        'course_session_group_id'       => $session->group_id,
                        'related_to_group_subscription' => 1,
                        'course_id'                     => $session->course_id
                    ]);
                }
            }
            if($session = $sessions->first()){
                UserCourse::create([
                    "course_id"           => $session->course_id,
                    "group_id"            => $id,
                    "user_id"             => $user->id,
                    "lecturer_id"         => Courses::find($session->course_id)->user_id,
                    "subscription_token"  => null,
                    "is_paid"             => 1,
                    "is_complete_payment" => 1,
                    'is_installment'      => 1
                ]);
            }
        }else{
            $courseSession = CourseSessionSubscription::create([
                'student_id'                    => $user->id,
                'course_session_id'             => $id,
                'status'                        => 1,
                'subscription_date'             => now(),
                'course_session_group_id'       => $model->group_id,
                'related_to_group_subscription' => 0,
                'course_id'                     => $model->course_id
            ]);
            UserCourse::create([
                "course_id"           => $courseSession->course_id,
                "user_id"             => $user->id,
                "lecturer_id"         => Courses::find($courseSession->course_id)->user_id,
                "subscription_token"  => null,
                "is_paid"             => 1,
                "is_complete_payment" => 1,
                'is_installment'      => 1
            ]);
        }

        return $this->response_api('success' , __('message.operation_accomplished_successfully') );
    }

    function subscribeDetails(Request $request){


        if($request->type == "group")
        {
            $title = CourseSessionsGroup::find($request->target_id)->title??"";
            $model = CourseSessionsGroup::find($request->target_id);

        }else{
            $title = CourseSession::find($request->target_id)->title??"";
            $model = CourseSession::find($request->target_id);

        }
        $price = $model->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }
        if($price >= 250)$msg = '';
        else $msg = __('amount_must_exceed_1000_iqd');


        $paymentMethods = [
            [
                'name' => 'zain',
                'image' => url('/assets/front/images/zain-cash.png'),
                'message' => $msg
            ]
        ];
        if(getSeting('qi')){
            $paymentMethods[] = [
                'name' => 'gateway',
                'image' => url('/assets/front/images/qi-logo.png'),
                'message' => ''
            ];
        }

        $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
            'course_details' => ['title' => $title],
            'payment_methods' => $paymentMethods
        ],Response::HTTP_OK);

        return response()->success($response);


    }

    function subscribe(Request $request){
        if($request->payment_type == "gateway")
        {
            return $this->subscribeGateway($request);
        }else{
            return $this->subscribeZain($request);
        }
    }


    public function subscribeGateway(Request $request)
    {

        if($request->type == "group"){
            $redirect = url('/api/payment/subscribe-to-course-group-confirm');
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
            $model = CourseSessionsGroup::find($request->target_id);
        }else{
            $redirect = url('/api/payment/subscribe-to-course-sessions-confirm');
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
            $model = CourseSession::find($request->target_id);
        }
        $orderId = genereatePaymentOrderID();

        $price = $model->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        $response = $this->paymentService->processPaymentApi([
            "amount" => $price,
            "currency" => "IQD",
            "successUrl" => $redirect,
            "orderId" => $orderId,
            'notificationUrl' => ''
        ]);



        if($response && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $model->price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "card",
                'coupon' => $request->get('code')
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);


            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $response['formUrl']
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            return $response;
            $response = new ErrorResponse(__('message.unexpected_error'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function subscribeZain($request){
        if($request->type == "group")
        {
            $model = CourseSessionsGroup::find($request->target_id);
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
            $redirect = url('/api/payment/subscribe-to-course-group-confirm');

        }else{
            $model = CourseSession::find($request->target_id);
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
            $redirect = url('/api/payment/subscribe-to-course-sessions-confirm');

        }
        $orderId = genereatePaymentOrderID();

        $price = $model->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        $response = $this->zainCashService->processPaymentApi($price,
        $redirect, $description,$orderId);

        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $model->price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $request->course_id,
                "purchase_type" => $request->type,
                'coupon' => $request->get('code')
            ];

            $this->paymentService->createTransactionRecordApi($paymentDetails);

            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $paymentUrl
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['err']['msg'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    public function confirmSubscribe(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
            $token = $request->get('token');
            if($cartId == null){
                $data = JWT::decode($token, new Key(env('ZAINCASH_SECRET_KEY'), 'HS256'));
                $cartId = $data->orderid;
            }
            $paymentDetails = Transactios::where('order_id',$cartId)->first();

            if($paymentDetails["brand"] == "card"){

                $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
                {
                    return redirect('/payment-failure');
                }
            }else{
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);
                if($statusCheck["status"] == "failed")
                {
                    return redirect('/payment-failure');
                }
            }

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
            $token = $request->get('token');
            if($cartId == null){
                $data = JWT::decode($token, new Key(env('ZAINCASH_SECRET_KEY'), 'HS256'));
                $cartId = $data->orderid;
            }
            $paymentDetails = Transactios::where('order_id',$cartId)->first();

            if($paymentDetails["brand"] == "card"){

                $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
                {
                    return redirect('/payment-failure');
                }
            }else{
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);
                if($statusCheck["status"] == "failed")
                {
                    return redirect('/payment-failure');
                }
            }

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


    function installmentDetails(Request $request){

        $installment = $this->getCurInstallment($request->course_id);

        if(!$installment){
            $response = new ErrorResponse(__('all_installments_have_been_paid'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $price = $installment->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        if($price >= 250)$msg = '';
        else $msg = __('amount_must_exceed_1000_iqd');


        $course = Courses::find($request->course_id);
        $installmetns = $course->installments;
        $remaining = $this->getRemainingInstallment($request->course_id);

        $paymentMethods = [
            [
                'name' => 'zain',
                'image' => url('/assets/front/images/zain-cash.png'),
                'message' => $msg
            ]
        ];
        if(getSeting('qi')){
            $paymentMethods[] = [
                'name' => 'gateway',
                'image' => url('/assets/front/images/qi-logo.png'),
                'message' => ''
            ];
        }


        $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
            'course_details' => [
                'course' => new ApiCourseResource($course),
                'installments' => ApiPaymentInstallmentsResource::collection($installmetns),
                'times' => ApiPaymentInstallmentsTimesResource::collection($remaining)
            ],
            'price' => $installment->price,
            'payment_methods' => $paymentMethods
        ],Response::HTTP_OK);

        return response()->success($response);

    }

    function installment(Request $request){
        if($request->payment_type == "gateway")
        {
            return $this->installmentGateway($request);
        }else{
            return $this->installmentZain($request);
        }
    }



    function installmentGateway(Request $request){

        $orderId = genereatePaymentOrderID();

        $installment = $this->getCurInstallment($request->course_id);

        if(!$installment){
            $response = new ErrorResponse(__('all_installments_have_been_paid'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $price = $installment->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        $response = $this->paymentService->processPaymentApi([
            "amount" => $price,
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
                "amount" => $installment->price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $installment->id,
                "brand" => "card",
                'course_id' => $request->course_id,
                'coupon' => $request->get('code')
            ];
            $this->paymentService->createTransactionRecordApi($paymentDetails);


            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $response['formUrl']
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['err']['msg'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function installmentZain($request){
        $orderId = genereatePaymentOrderID();

        $installment = $this->getCurInstallment($request->course_id);

        if(!$installment){
            $response = new ErrorResponse(__('all_installments_have_been_paid'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $price = $installment->price;

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }


        $response = $this->zainCashService->processPaymentApi($price,
        url('/api/payment/pay-to-course-session-installment-confirm'),"دفع قسط جلسات دورة",$orderId);

        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $installment->price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $installment->id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $request->course_id,
                'coupon' => $request->get('code')
            ];
            $this->paymentService->createTransactionRecordApi($paymentDetails);



            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $paymentUrl
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['error'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function getCurInstallment($courseId){

        $last = StudentSessionInstallment::where('course_id',$courseId)->where('student_id',auth('api')->id())->orderBy('access_until_session_id', 'desc')->first();

        if($last)$id = $last->access_until_session_id;
        else $id = 0;
        $installment = CourseSessionInstallment::where('course_id',$courseId)->where('course_session_id','>',$id)->first();
        return $installment;
    }

    function getRemainingInstallment($courseId){
        $cur = $this->getCurInstallment($courseId);
        if(!$cur)return CourseSessionInstallment::where('course_id',$courseId)->get();
        return  CourseSessionInstallment::where('course_id',$courseId)->where('id','>=',$cur->id)->get();
    }

    function confirmPayment(Request $request){
        DB::beginTransaction();
        try
        {

            $cartId = $request->get('requestId');
            $token = $request->get('token');
            if($cartId == null){
                $data = JWT::decode($token, new Key(env('ZAINCASH_SECRET_KEY'), 'HS256'));
                $cartId = $data->orderid;
            }
            $paymentDetails = Transactios::where('order_id',$cartId)->first();

            //check qi payment status
            if($paymentDetails["brand"] == "card"){

                $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
                {
                    return redirect('/payment-failure');
                }
            }else{
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);
                if($statusCheck["status"] == "failed")
                {
                    return redirect('/payment-failure');
                }
            }
            $paymentDetails->status = 'completed';
            $paymentDetails->is_paid = 1;
            $paymentDetails->save();

            $courseSession = CourseSessionInstallment::find($paymentDetails['transactionable_id']);
            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => $paymentDetails['user_id'],
                'course_id' => $courseSession->course_id,
                'access_until_session_id' => $courseSession->course_session_id
            ]);

            UserCourse::create([
                "course_id" => $courseSession->course_id,
                "user_id" => $paymentDetails['user_id'],
                "lecturer_id" => Courses::find($courseSession->course_id)->user_id,
                "subscription_token"  => $paymentDetails['payment_id'],
                "is_paid" => 1,
                "is_complete_payment" => 1,
                'is_installment' => 1
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

    function privateLessonDetails(Request $request){
        $price = 0;
        foreach($request->get('times') as $time){
            $price += $time['price'];
        }

        if(!$price){
            $response = new ErrorResponse(__('the_price_should_be_greater_than_zero'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }


        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        if($price >= 250)$msg = '';
        else $msg = __('amount_must_exceed_1000_iqd');



        $paymentMethods = [
            [
                'name' => 'zain',
                'image' => url('/assets/front/images/zain-cash.png'),
                'message' => $msg
            ]
        ];
        if(getSeting('qi')){
            $paymentMethods[] = [
                'name' => 'gateway',
                'image' => url('/assets/front/images/qi-logo.png'),
                'message' => ''
            ];
        }


        $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
            'course_details' => $request->get('times'),
            'price' => $price,
            'payment_methods' => $paymentMethods
        ],Response::HTTP_OK);

        return response()->success($response);
    }

    function privateLesson(Request $request){
        if($request->payment_type == "gateway")
        {
            return $this->privateLessonGateway($request);
        }else{
            return $this->privateLessonZain($request);
        }
    }

    function privateLessonGateway(Request $request){

        $orderId = genereatePaymentOrderID();

        $price = 0;
        foreach($request->get('times') as $time){
            $price += $time['price'];
        }

        if(!$price){
            $response = new ErrorResponse(__('the_price_should_be_greater_than_zero'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }

        $response = $this->paymentService->processPaymentApi([
            "amount" => $price,
            "currency" => "IQD",
            "successUrl" => url('/api/payment/pay-to-private-lesson-confirm'),
            "notificationUrl" => url('/api/payment/pay-to-private-lesson-confirm'),
            'orderId' => $orderId
        ]);
        if($response && $response['status'] == "CREATED")
        {

            foreach($request->get('times') as $time){
                $detail = PaymentDetail::create([
                    'details' => json_encode($time)
                ]);
                $paymentDetails = [
                    "description" => "دفع درس خصوصي",
                    "orderId" => $response['requestId'],
                    "payment_id" => $response['paymentId'],
                    "amount" => $time['price'],
                    "transactionable_type" => "App\\Models\\PrivateLessons",
                    "transactionable_id" => $detail->id,
                    "brand" => "card",
                    'coupon' => $request->get('code')
                ];
                $this->paymentService->createTransactionRecordApi($paymentDetails);
            }


            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $response['formUrl']
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['err']['msg'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function privateLessonZain($request){
        $orderId = genereatePaymentOrderID();

        $price = 0;
        foreach($request->get('times') as $time){
            $price += $time['price'];
        }

        if(!$price){
            $response = new ErrorResponse(__('the_price_should_be_greater_than_zero'),Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $price_after_discount = $this->getPriceWithCoupon($price , $request->get('code'));

        if($price_after_discount['status']){
            $price = $price_after_discount['price'];
        }


        $response = $this->zainCashService->processPaymentApi($price,
        url('/api/payment/pay-to-private-lesson-confirm'),"دفع درس خصوصي",$orderId);

        if(isset($response['id']))
        {

            foreach($request->get('times') as $time){
                $detail = PaymentDetail::create([
                    'details' => json_encode($time)
                ]);
                $paymentDetails = [
                    "description" => "دفع درس خصوصي",
                    "orderId" => $response['orderId'],
                    "payment_id" => $response['id'],
                    "amount" => $time['price'],
                    "transactionable_type" => "App\\Models\\PrivateLessons",
                    "transactionable_id" => $detail->id,
                    "brand" => "zaincash",
                    "transaction_id" => $response['referenceNumber'],
                    'coupon' => $request->get('code')
                ];
                $this->paymentService->createTransactionRecordApi($paymentDetails);
            }



            $transaction_id = $response['id'];
            $paymentUrl = env('ZAINCASH_REDIRECT_URL').$transaction_id;

            $response = new SuccessResponse(__('message.operation_accomplished_successfully') , [
                'payment_link' => $paymentUrl
            ],Response::HTTP_OK);

            return response()->success($response);
        }else{
            $response = new ErrorResponse($response['error'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function privateLessonConfirm(Request $request){

        DB::beginTransaction();
        try
        {

            $cartId = $request->get('requestId');
            $token = $request->get('token');
            if($cartId == null){
                $data = JWT::decode($token, new Key(env('ZAINCASH_SECRET_KEY'), 'HS256'));
                $cartId = $data->orderid;
            }
            $paymentDetails = Transactios::where('order_id',$cartId)->first();

            //check qi payment status
            if($paymentDetails["brand"] == "card"){

                $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);

                if($paymentDetails["brand"] == "card" && $statusCheck["status"] != "SUCCESS")
                {
                    return redirect('/payment-failure');
                }
            }else{
                $statusCheck = $this->zainCashService->checkPaymentStatus($paymentDetails['payment_id']);
                if($statusCheck["status"] == "failed")
                {
                    return redirect('/payment-failure');
                }
            }

            $paymentDetails = Transactios::where('order_id',$cartId)->get();

            foreach($paymentDetails as $payment){
                $payment->status = 'completed';
                $payment->is_paid = 1;
                $payment->save();

                $detail = PaymentDetail::find($payment->transactionable_id);
                $detail = json_decode($detail->details,1);

                $privateLesson = PrivateLessons::create([
                    'category_id' => 0,
                    'teacher_id' => $detail['teacher_id'],
                    'student_id' => $payment->user_id,
                    'price' => $detail['price'],
                    'meeting_date' => $detail['meeting_date'],
                    'time_form' => $detail['from'],
                    'time_to' => $detail['to'],
                    'time_type' => $detail['type'],
                    'status' => 'acceptable'
                ]);



                $this->paymentService->storeBalanceApi($payment,'private_lesson',$detail['teacher_id']);
            }



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
            return $e->getMessage();
            return redirect('/payment-failure');
        }


    }



    ///


    function freeInstallment(freeInstallmentRequest $request)
    {
        $installment = $this->getCurInstallment($request->course_id);
        if(!$installment){
            return $this->response_api('error' , __('validation.installment_not_foud') );
        }
        $price = $installment->price;

        if($price > 0){
            return $this->response_api('error' , __('validation.installment_not_Free') , ['price' => $price]);
        }

        $courseSession = $installment;
        $item = StudentSessionInstallment::updateOrCreate([
            'student_id'              => auth('api')->id(),
            'course_id'               => $courseSession->course_id,
            'access_until_session_id' => $courseSession->course_session_id
        ]);

        UserCourse::create([
            "course_id"           => $courseSession->course_id,
            "user_id"             => auth('api')->id(),
            "lecturer_id"         => Courses::find($courseSession->course_id)->user_id,
            "is_paid"             => 1,
            "is_complete_payment" => 1,
            'is_installment'      => 1
        ]);

        return $this->response_api('success' , __('free_installment_reserved_successfully') );

    }


    function getPriceWithCoupon($amount,$code){
        $coupon = Coupons::where('code', $code)->first();

        if ($coupon == '') {
            $response=[
                'status'=>false,
            ];

            return $response;
        }

        $checkNumUses = Transactios::where('coupon', $code)->where('status' , 'completed')->count();
        if ($coupon->num_uses != '') {
            if ($checkNumUses > $coupon->num_uses) {
                return ['status' => false];
            }
        }

        if (@$coupon->amount_type == 'fixed') {
            $amount_after_discount = round($amount - $coupon->amount);
        }else{
            $amount_after_discount = ($amount - ($amount * ($coupon->amount / 100)));
        }


        $response=[
            'status'=> true,
            'price' => $amount_after_discount
        ];
        return $response;
    }




}
