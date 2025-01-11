<?php

namespace App\Http\Controllers\Front\User;

use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{StudentSessionInstallment,CourseSession,PaymentDetail,Coupons,Balances,Transactios};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Repositories\Common\CourseCurriculumEloquent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\CourseSessionInstallment;
use App\Models\Courses;
use Carbon\Carbon;

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
        $course = Courses::find($request->course_id);
        
        if(! canStudentSubscribeToCourse(@$course->id, 'installment'))
        {
            return back();
        }

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

        //calc course price after coupon
        $itemPrice = $data['price'];
        $price = $itemPrice;
        $coupon = $request['marketer_coupon'];
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $itemPrice;
            $itemPriceAfterCoupon = $itemPrice - $rateVal;
        }else{
            $itemPriceAfterCoupon = $itemPrice - $coupon->amount;
        }
        $price = $itemPriceAfterCoupon;
            }
        }

        $data['price'] =  $price;
        $data['marketer_coupon'] = $request->marketer_coupon;

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

        //calc course price after coupon
        $itemPrice = $price;
        $price = $itemPrice;
        $coupon = $request['marketer_coupon'];
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $itemPrice;
            $itemPriceAfterCoupon = $itemPrice - $rateVal;
        }else{
            $itemPriceAfterCoupon = $itemPrice - $coupon->amount;
        }
        $price = $itemPriceAfterCoupon;
            }
        }
 
       $response = $this->paymentService->processPayment([
            "amount" => $price,
            "currency" => "IQD"
        ]);  
        
        if($response && isset($response['status']) && $response['status'] == "CREATED")
        {
            $paymentDetails = [
                "description" => "دفع قسط جلسات دورة",
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "amount" => $price,
                "transactionable_type" => "App\\Models\\CourseSession",
                "transactionable_id" => $request->id,
                "brand" => "card",
                'course_id' => $request->course_id,
                "user_id" => auth('web')->user()->id,
                "marketer_coupon" => $request->marketer_coupon,
                "payment_type" => "installment"
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
        $installment = CourseSessionInstallment::where('course_session_id',$request->id)->where('course_id',$request->course_id)->first();
        if(! $installment)
        {
            return back();
        }
        $price = $installment->price ?? 0;
        //calc course price after coupon
        $itemPrice = $price;
        $price = $itemPrice;
        $coupon = $request['marketer_coupon'];
        if ($coupon) {
            $coupon = Coupons::where('code', $coupon)->first();
            if (@$coupon->isValid()) {
        if($coupon->amount_type == "rate")
        {
            $rateVal = ($coupon->amount / 100) * $itemPrice;
            $itemPriceAfterCoupon = $itemPrice - $rateVal;
        }else{
            $itemPriceAfterCoupon = $itemPrice - $coupon->amount;
        }
        $price = $itemPriceAfterCoupon;
            }
        }

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
                'course_id' => $request->course_id,
                "marketer_coupon" => $request->marketer_coupon,
                "payment_type" => "installment"
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

            UserCourse::updateOrCreate([
                "course_id" => $paymentDetails['course_id'],
                "user_id" => auth('web')->user()->id,
            ],[
                "lecturer_id" => Courses::find($paymentDetails['course_id'])->user_id,
                "subscription_token"  => $paymentDetails['payment_id'],
                "is_paid" => 1,
                "is_complete_payment" => 1,
                'is_installment' => 1
            ]);
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
                $itemPrice = @CourseSessionInstallment::where('course_session_id',$request['transactionable_id'])->where('course_id',$request['course_id'])->first()->price ?? 0;
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

                $user_name = auth()->user('web')->name;
                $marketer_name = $marketer->user->name;

                // save Transactios
                $params_transactios = [
                    'description'            => "اشتراك قسط $user_name عبر رابط المسوق $marketer_name",
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
                    'description' => " اشتراك قسط للطالب $user_name عبر رابطك",
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

            $item = StudentSessionInstallment::updateOrCreate([
                'student_id' => $paymentDetails['user_id'],
                'course_id' => $paymentDetails['course_id'],
                'access_until_session_id' => $paymentDetails['transactionable_id'],
            ]);

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
