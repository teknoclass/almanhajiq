<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{CourseSessionSubscription,CourseSession,CourseSessionsGroup,PaymentDetail, User,Coupons,Balances,Transactios};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;

class CourseSessionSubscriptionsController extends Controller
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
        $data['id'] = $request->id;
        $data['course_id'] = $request->course_id;
        $data['type'] = $request->type;
        if($request->type == "session")
        {
            $item = CourseSession::find($request->id);
            if(! $item)
            {
                return back();
            }
            $data['price'] = $item->price ?? 0;
        }else{
            $item = CourseSessionsGroup::find($request->id);
            if(! $item)
            {
                return back();
            }
            $data['price'] = $item->price ?? 0;   
        }

        //if free
        if($data['price'] == 0 || $data['price'] == "")
        {
            $studentSubscribedSessionsIds = auth('web')->user()->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            if($request->type == "group")
            {
            $sessions = CourseSession::where('group_id', $request->id)->get();

            foreach($sessions as $session)
            {
                    if(! in_array( $session->id,$studentSubscribedSessionsIds))
                    {
                        CourseSessionSubscription::create([
                            'student_id' => auth('web')->user()->id,
                            'course_session_id' => $session->id,
                            'status' => 1,
                            'subscription_date' => now(),
                            'course_session_group_id' => $session->group_id,
                            'related_to_group_subscription' => 1,
                            'course_id' => $session->course_id
                        ]);
                    }
            }
            }
            elseif($request->type == "session")
            {
            $session = CourseSession::find($request->id);

            if(! in_array($session->id, $studentSubscribedSessionsIds))
            {
                    CourseSessionSubscription::create([
                        'student_id' => auth('web')->user()->id,
                        'course_session_id' => $session->id,
                        'status' => 1,
                        'subscription_date' => now(),
                        'course_session_group_id' => $session->group_id,
                        'related_to_group_subscription' => 0,
                        'course_id' => $session->course_id
                    ]);
                }
            }

            return redirect("/user/courses/curriculum/item/".$request->course_id);
        }

        //if has coupon
        $coupon = $request['marketer_coupon'];
        $sessionPrice =  $data['price'];
        $price = $sessionPrice;
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $sessionPrice;
            $sessionPriceAfterCoupon = $sessionPrice - $rateVal;
        }else{
            $sessionPriceAfterCoupon = $sessionPrice - $coupon->amount;
        }
        $price = $sessionPriceAfterCoupon;
            }
        }
        $data['price'] =  $price;
        $data['marketer_coupon'] = $request->marketer_coupon;

        return view('front.payment-options.offer-subscription', $data);
    }

    public function subscribe(Request $request)
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
        if($request->type != "group")
        {
            $item = CourseSession::find($request->target_id);
            if(! $item)
            {
                return back();
            }
            $price = $item->price ?? 0;
        }else{
            $item = CourseSessionsGroup::find($request->target_id);
            if(! $item)
            {
                return back();
            }
            $price = $item->price ?? 0;   
        }

        $coupon = $request['marketer_coupon'];
        $sessionPrice =  $price;
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $sessionPrice;
            $sessionPriceAfterCoupon = $sessionPrice - $rateVal;
        }else{
            $sessionPriceAfterCoupon = $sessionPrice - $coupon->amount;
        }
        $price = $sessionPriceAfterCoupon;
            }
        }
        $price =  $price;

        $response = $this->paymentService->processPayment([
            "amount" => $price,
            "currency" => "IQD",
            "finishPaymentUrl" => url('/user/subscribe-to-course-sessions-confirm'),
            "notificationUrl" => url('/subscribe-to-course-sessions-webhook'),
        ]);  
      
        if($request->type == "group")
        {
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
        }else{
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
        }

        if($response && isset($response['status']) && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "card",
                'course_id' => $request->course_id,
                "purchase_type" => $request->type,
                "user_id" => auth('web')->user()->id,
                "marketer_coupon" => $request->marketer_coupon,
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
            storePaymentDetails($paymentDetails);

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
        if($request->type != "group")
        {
            $item = CourseSession::find($request->target_id);
            if(! $item)
            {
                return back();
            }
            $price = $item->price ?? 0;
        }else{
            $item = CourseSessionsGroup::find($request->target_id);
            if(! $item)
            {
                return back();
            }
            $price = $item->price ?? 0;   
        }

        $coupon = $request['marketer_coupon'];
        $sessionPrice =  $price;
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $sessionPrice;
            $sessionPriceAfterCoupon = $sessionPrice - $rateVal;
        }else{
            $sessionPriceAfterCoupon = $sessionPrice - $coupon->amount;
        }
        $price = $sessionPriceAfterCoupon;
            }
        }
        $price =  $price;

        if($request->type == "group")
        {
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
        }else{
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
        }

        $response = $this->zainCashService->processPayment($price,
        url('/user/subscribe-to-course-sessions-confirm'), $description);  
      
       
        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $request->course_id,
                "purchase_type" => $request->type,
                "marketer_coupon" => $request->marketer_coupon,
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

    
    public function confirmSubscribe()
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
    
            $studentSubscribedSessionsIds = auth('web')->user()->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            if($paymentDetails['purchase_type'] == "group")
            {
            $sessions = CourseSession::where('group_id', $paymentDetails['transactionable_id'])->get();

            foreach($sessions as $session)
            {
                    if(! in_array( $session->id,$studentSubscribedSessionsIds))
                    {
                        CourseSessionSubscription::create([
                            'student_id' => auth('web')->user()->id,
                            'course_session_id' => $session->id,
                            'status' => 1,
                            'subscription_date' => now(),
                            'course_session_group_id' => $session->group_id,
                            'related_to_group_subscription' => 1,
                            'course_id' => $session->course_id
                        ]);
                    }
            }
            }
            elseif($paymentDetails['purchase_type'] == "session")
            {
            $session = CourseSession::find($paymentDetails['transactionable_id']);

            if(! in_array($session->id, $studentSubscribedSessionsIds))
            {
                    CourseSessionSubscription::create([
                        'student_id' => auth('web')->user()->id,
                        'course_session_id' => $session->id,
                        'status' => 1,
                        'subscription_date' => now(),
                        'course_session_group_id' => $session->group_id,
                        'related_to_group_subscription' => 0,
                        'course_id' => $session->course_id
                    ]);
                }
            }

            $sessionPriceAfterCoupon = $this->executeCoupon($paymentDetails);

            if($sessionPriceAfterCoupon)
            {
                $paymentDetails['amount'] = $sessionPriceAfterCoupon;
            }

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

    public function executeCoupon($request)
    {
        $coupon = $request['marketer_coupon'];
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
                $marketer = $coupon->marketer;

                $marketer_amount = $coupon->marketer_amount;
                $marketer_amount_type = $coupon->marketer_amount_type;
                $user_name = auth()->user('web')->name;
                $marketer_name = $marketer->user->name;
                if($request['purchase_type'] == "session")
                {
                    $itemPrice = CourseSession::find($request['transactionable_id'])->price ?? 0;
                    $descriptionT = "اشتراك عرض شراء جلسة $user_name عبر رابط المسوق $marketer_name";
                }else{
                    $itemPrice = CourseSessionsGroup::find($request['transactionable_id'])->price ?? 0;
                    $descriptionT = "اشتراك عرض شراء مجموعة جلسات $user_name عبر رابط المسوق $marketer_name";
                }
                //calc course price after coupon
                if($coupon->amount_type == "rate")
                {
                    $rateVal = ($coupon->amount / 100) * $itemPrice;
                    $itemPriceAfterCoupon = $itemPrice - $rateVal;
                }else{
                    $itemPriceAfterCoupon = $itemPrice - $coupon->amount;
                }
                if($marketer_amount_type == "rate" && $itemPriceAfterCoupon)
                {
                    $marketer_amount = ($marketer_amount/100) * $itemPriceAfterCoupon;
                }

                // save Transactios
                $params_transactios = [
                    'description'            => $descriptionT,
                    'user_id'                => $marketer->user_id,
                    'user_type'              => Transactios::MARKETER,
                    'payment_id'             => uniqid(),
                    'amount'                 => $marketer_amount,
                    'amount_before_discount' => 0,
                    'type'                   => Transactios::DEPOSIT,
                    'transactionable_id'     => $marketer->user_id,
                    'transactionable_type'   => get_class($marketer->user),
                    'coupon'                 => $coupon->code,
                ];

                $this->saveTransactios($params_transactios);

                // add balance to marketer

                $params_balance = [
                    'description' => $descriptionT,
                    'user_id' => $marketer->user_id,
                    'user_type' => Balances::MARKETER,
                    'transaction_id' => $marketer->user_id,
                    'transaction_type' => get_class($marketer),
                    'amount' => $marketer_amount,
                    'system_commission' => 0,
                    'amount_before_commission' => $marketer_amount,
                    'becomes_retractable_at' => Carbon::now(),
                    'is_retractable' => 1,
                ];

                $this->addBalance($params_balance);

                return $itemPriceAfterCoupon;
            }
        }
    }
    public function addBalance(array $params)
    {
        Balances::updateOrCreate([
            'payment_id' => $paymentDetails['payment_id'] ?? null,
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'type' => Balances::DEPOSIT,
            'transaction_id' => $params['transaction_id'],
        ],[
            'description' => $params['description'],           
            'transaction_type' => $params['transaction_type'],
            'amount' => $params['amount'],
            'system_commission' => $params['system_commission'],
            'amount_before_commission' => $params['amount_before_commission'],
            'becomes_retractable_at' => $params['becomes_retractable_at'],
            'is_retractable' => $params['is_retractable'],

        ]);

        return true;
    }

    public function saveTransactios(array $params)
    {
        Transactios::updateOrCreate([
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'payment_id' => $params['payment_id'],
        ],[
            'description' => $params['description'],
            'amount' => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type' => $params['type'],
            'transactionable_id' => $params['transactionable_id'],
            'transactionable_type' => $params['transactionable_type'],
            'coupon' => isset($params['coupon']) ? $params['coupon'] : '',
        ]);

        return '';
    }

    public function handleWebhook(Request $request)
    {
        DB::beginTransaction();
        try {

            $paymentId = $request->input('paymentId') ?? $request->input('payment_id');
            $paymentDetails = getPaymentDetails($paymentId);
            if(! $paymentDetails)
            {
                return response()->json(['error' => 'Payment Failed'], 400);
            }
            $statusCheck = $this->paymentService->checkPaymentStatus($paymentDetails['payment_id']);
    
            if((!isset($statusCheck["status"])) || (isset($statusCheck["status"]) && $statusCheck["status"] != "SUCCESS"))
            {
                return response()->json(['error' => 'Payment Failed'], 403);
            }

            $studentSubscribedSessionsIds = User::find($paymentDetails['user_id'])->studentSubscribedSessions()->pluck('course_session_id')->toArray();

            if($paymentDetails['purchase_type'] == "group")
            {
            $sessions = CourseSession::where('group_id', $paymentDetails['transactionable_id'])->get();

            foreach($sessions as $session)
            {
                    if(! in_array( $session->id,$studentSubscribedSessionsIds))
                    {
                        CourseSessionSubscription::create([
                            'student_id' => auth('web')->user()->id,
                            'course_session_id' => $session->id,
                            'status' => 1,
                            'subscription_date' => now(),
                            'course_session_group_id' => $session->group_id,
                            'related_to_group_subscription' => 1,
                            'course_id' => $session->course_id
                        ]);
                    }
            }
            }
            elseif($paymentDetails['purchase_type'] == "session")
            {
            $session = CourseSession::find($paymentDetails['transactionable_id']);

            if(! in_array($session->id, $studentSubscribedSessionsIds))
            {
                    CourseSessionSubscription::create([
                        'student_id' => auth('web')->user()->id,
                        'course_session_id' => $session->id,
                        'status' => 1,
                        'subscription_date' => now(),
                        'course_session_group_id' => $session->group_id,
                        'related_to_group_subscription' => 0,
                        'course_id' => $session->course_id
                    ]);
                }
            }

            $this->paymentService->createTransactionRecord($paymentDetails);

            $this->paymentService->storeBalance($paymentDetails);

            session()->forget('payment-'.$paymentDetails['user_id']);

            DB::commit();

            return response()->json(['message' => 'Webhook handled successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e->getFile());
            Log::error($e->getLine());
            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }
   

}