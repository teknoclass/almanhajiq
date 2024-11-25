<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{Courses, UserCourse,Coupons,Balances,Transactios};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;

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
        $data['price'] =  $course->getPriceForPayment();
        $data['marketer_coupon'] = $request->marketer_coupon;

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
            "amount" => $course->getPriceForPayment(),
            "currency" => "IQD",
            "finishPaymentUrl" => url('/user/full-subscribe-course-confirm'),
            "notificationUrl" => url('/user/full-subscribe-course-confirm')
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
                "marketer_coupon" => $request->marketer_coupon
            ];
    
            session()->put('payment-'.auth('web')->user()->id,$paymentDetails);
 
            return  $response = [
                'status_msg' => 'success',
                'status' => 200,
                'payment' => true,
                'redirect_url' => $response['formUrl']
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

        $response = $this->zainCashService->processPayment($course->getPriceForPayment(),
        url('/user/full-subscribe-course-confirm'),"اشتراك كلى فى دورة"); 
        
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
                "purchase_type" => $request->type,
                "marketer_coupon" => $request->marketer_coupon
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
    
            $this->executeCoupon($paymentDetails);

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

                // save coupon
                // $user->coupon_id = $coupon->id;
                // $user->market_id = $marketer->user_id;
                // $user->update();

                $marketer_amount = $coupon->marketer_amount;

                $user_name = auth()->user('web')->name;
                $marketer_name = $marketer->user->name;

                // save Transactios
                $params_transactios = [
                    'description'            => "تسجيل دورة $user_name عبر رابط المسوق $marketer_name",
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
                    'description' => " تسجيل مقرر للطالب $user_name عبر رابطك",
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
            }
        }
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'type' => Balances::DEPOSIT,
            'transaction_id' => $params['transaction_id'],
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
        Transactios::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'payment_id' => $params['payment_id'],
            'amount' => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type' => $params['type'],
            'transactionable_id' => $params['transactionable_id'],
            'transactionable_type' => $params['transactionable_type'],
            'coupon' => isset($params['coupon']) ? $params['coupon'] : '',
        ]);

        return '';
    }


}