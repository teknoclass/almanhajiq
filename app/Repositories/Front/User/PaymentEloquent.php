<?php

namespace App\Repositories\Front\User;

use App\Libraries\Iyzico;
use App\Models\Transactios;
use App\Models\UserCourse;
use App\Repositories\Front\CouponsEloquent;
use App\Repositories\Front\CoursesEloquent as CoursesEloquentV0;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\Balances;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentEloquent extends HelperEloquent
{
    public function checkoutV0($request, $action_type, $action_id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $price=0;
        $item_id=0;
        $item_title="";
        $item_category="";
        if ($action_type=='user_course') {
            $user_course=UserCourse::where('subscription_token', $action_id)->where('is_complete_payment', 0)->first();
            if (!$user_course) {
                abort(404);
            }
            $course=$user_course->course;
            $course_eloquent=new CoursesEloquentV0();
            $price=$course_eloquent->getPrice($course->id);

            //item
            $item_id=$course->id;
            $item_title=$course->title;
            $item_category=$course->category->name;
        }

        $payment_callback=route('user.payment.checkStatus', [
            'action_type'=>$action_type,
            'action_id'=>$action_id
        ]);

        //coupon
        $coupon=$request->get('coupon');
        $course_eloquent=new CouponsEloquent();
        if($coupon) {
            $check_coupon=$course_eloquent->check($coupon, $price);
            if ($check_coupon['status']) {
                $price=$check_coupon['items']['amount_after_discount_2'];
            }
            $payment_callback=$payment_callback.'?coupon='.$coupon;
        }



        $iyzico = new Iyzico();
        $payment = $iyzico->setForm([
            'conversationID' => uniqid(),
            'price' => floatval($price),
            'paidPrice' => floatval($price),
            'basketID' => uniqid(),
            'payment_callback'=>$payment_callback,
            'enabled_installments'=>array(2, 3, 6, 9),
        ])
            ->setBuyer([
                'id' => $data['user']->id,
                'name' => $data['user']->name,
                'surname' => $data['user']->name,
                'phone' => $data['user']->mobile,
                'email' => $data['user']->email,
                'identity' => $data['user']->id .'9999',
                'address' =>'address: '. @$data['user']->country->name,
                'ip' => \request()->ip(),
                'city' =>'City: '. @$data['user']->city->name,
                'country' =>'country: '. @$data['user']->country->name,
            ])
            ->setBilling([
                'name' => $data['user']->name,
                'address' =>'address: '. @$data['user']->country->name,
                'city' =>'City: '. @$data['user']->city->name,
                'country' =>'country: '. @$data['user']->country->name,
            ])
            ->setItems([
                [
                    'id' => $item_id,
                    'name' => $item_title,
                    'category' => $item_category,
                    'price' => floatval($price)
                ],
            ])
            ->paymentForm();

        return [
            'payment_content' => $payment->getCheckoutFormContent(),
            'payment_status' => $payment->getStatus(),
        ];
    }

    // ----------- START STRIPE -----------------
    function init($request)
    {
        // Set your Stripe secret key
        // Stripe::setApiKey(env('STRIPE_KEY')); // published
        Stripe::setApiKey(env('STRIPE_SECRET' , "sk_test_51HTpx3Azqp7r8LnoqWclZ9DPc9sMC3XWSBmkLgYELg0Tz155hAikfQiijtSsfbNAFbHANEfd646ttSyjV3eBlf7N001qiiO3XA"));

        try {

            $user                   = auth('web')->user();
            $currency_exchange_rate = $user->country->currency_exchange_rate;

            $transaction_id           = $request->transaction_id;

            $transaction = Transactios::where('user_id' , auth('web')->id())->where('is_paid' , 0)->find($transaction_id);
            if(!$transaction){
                return ['data' => ['error' => 'You Don`t have payment now'], 'status' => 500];
            }

            $price        = ceil($currency_exchange_rate * $transaction->amount); // re
            if(!$price){
                return [
                    'data'   => ['error' => 'No Price'],
                    'status' => 500 ,
                ];
                // return response()->json(['error' => 'No Price'], 500);
            }

            // $payable = $transaction->transactionable;

            $payment =  $transaction->payment()->where([['status' , 'pending'] ,["user_id" , $user->id]])->first();

            if(!$payment){
                // create payment row
                $payment =  $transaction->payment()->create([
                    "user_id"          => $user->id,
                    "payment_channel"  => 'stripe',
                    "payment_method"   => 'card',
                    "amount"           => $price,
                ]);
            }

            // Create a PaymentIntent
            $intent = PaymentIntent::create([
                'amount'   => (float)$price * 100 ,   // amount in cents
                'currency' => 'usd',
                // Other payment intent parameters...
            ]);

            // Send the client secret to the frontend
            return [
                'data'   => ['clientSecret' => $intent->client_secret , 'return_url'=>route('user.payment.checkStatus',['payment_id'=>$payment->id])],
                'status' => 200 ,
            ];
            // return response()->json(['clientSecret' => $intent->client_secret,'return_url'=>route('user.payment.success',['payment_id'=>$payment->id])]);
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'data'   => ['error' => $e->getMessage()],
                'status' => 500 ,
            ];
            // return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkStatus($request , $payment_id)
    {
        // Stripe::setApiKey(env('STRIPE_KEY'));
        Stripe::setApiKey(env('STRIPE_SECRET' , "sk_test_51HTpx3Azqp7r8LnoqWclZ9DPc9sMC3XWSBmkLgYELg0Tz155hAikfQiijtSsfbNAFbHANEfd646ttSyjV3eBlf7N001qiiO3XA"));
        $paymentIntent = PaymentIntent::retrieve($request->payment_intent);

        if($paymentIntent->status == 'succeeded')
        {
            // payment_id
           $payment               = Payment::where('status' , 'pending')->find($payment_id);
           if(!$payment){
                return [
                    'message'      => __("لم يتم الاشتراك"),
                    'redirect_url' => url('/'),
                ];
            }
            $payment->status       = 'completed';            // test
            $payment->operation_id = $paymentIntent->id;     // test
            $payment->save(); // test

            $transaction             = $payment->payable;
            $transaction->is_paid    = 1;
            $transaction->payment_id = $payment->id;
            $transaction->save();


            if($transaction->transactionable_type == 'App\Models\Courses'){
                (new CoursesEloquent())->pay_realated($transaction->id);
                return [
                    'message'      => __("تم الاشتراك والدفع بنجاح"),
                    'redirect_url' => route('user.courses.curriculum.item' , $transaction->transactionable_id),
                ];
            }
            elseif($transaction->transactionable_type == 'App\Models\PrivateLessons'){
                (new PrivateLessonsEloquent())->pay_realated($transaction->id);
                return [
                    'message'      => __("تم الاشتراك والدفع بنجاح"),
                    'redirect_url' => url('user/private-lessons'),
                ];
                // return redirect()->route('user.courses.curriculum.item' , $transaction->transactionable_id)->with(__("تم الاشتراك والدفع بنجاح"));
            }
            elseif($transaction->transactionable_type == 'App\Models\Packages' || $transaction->transactionable_type == 'App\Models\UserPackages'){
                return [
                    'message'      => __("تم الاشتراك والدفع بنجاح"),
                    'redirect_url' => url('user/packages'),
                ];
                // return redirect()->route('user.courses.curriculum.item' , $transaction->transactionable_id)->with(__("تم الاشتراك والدفع بنجاح"));
            }
        }
        return [
            'message'      => __("لم يتم الاشتراك"),
            'redirect_url' => url('/'),
        ];
        // return   redirect()->route('user.courses.curriculum.item' , 0)->with(__("لم يتم الاشتراك"));
    }
    // ----------- END STRIPE -----------------


    public function checkStatusV0($request, $action_type, $action_id)
    {
        $token = $request->token;
        $iyzico = new Iyzico();
        $response = $iyzico->callbackForm($token);

        //
        $status=false;
        $message=__('message.an_error_occurred_in_the_payment_process');
        $redirect_url=route('user.home.index');

        DB::beginTransaction();

        try {
            $payment_status = $response->getPaymentStatus();
            if ($payment_status == 'SUCCESS') {
                if ($action_type=='user_course') {
                    $response=$this->updateUserCourse($request, $action_id);
                    // status
                    $status=true;
                    $message=__('message.congratulations_your_payment_has_been_successful');

                    $redirect_url=$response['redirect_url'];
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            $status=false;
            $message=__('message.an_error_occurred_in_the_payment_process');
        }
            return [
                'status'=>$status,
                'message'=>$message,
                'redirect_url'=>$redirect_url
            ];
    }

    public function updateUserCourse($request, $action_id)
    {
        $item=UserCourse::where('subscription_token', $action_id)
        ->with('course')
        ->first();
        if (!$item) {
            abort(404);
        }

        // update  status of the payment
        $item->is_complete_payment=1;
        $item->update();

        //
        $course=$item->course;
        $course_title=$course->title;

        $this->financialMovementToParticipateCourse($item, $request);

        // send a notice to the lecturer of the student's participation
        $user_name=$item->user->name;

        $title = 'اشتراكات طلبة جدد';
        $text = "تم اشتراك $user_name بدورة $course_title";
        $action_type='live_course_subscriptions';
        $action_data=$item->id;
        $permation='';
        $user_type='user';
        $user_ids[]  =$item->lecturer_id;
        sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type, $user_ids);

        $redirect_url=route('courses.single', ['id'=>@$course->id,'title'=>mergeString(@$course->title, '')]);

        return [
            'status'=>true,
            'redirect_url'=>$redirect_url
        ];
    }

    public function financialMovementToParticipateCourse($user_course, $request)
    {

        $course=$user_course->course;

        $course_eloquent=new CoursesEloquent();
        $price=$course_eloquent->getPrice($course->id);

        $course_title=$course->title;

        $coupon=$request->get('coupon');
        if($coupon) {
            $course_eloquent=new CouponsEloquent();

            $check_coupon=$course_eloquent->check($coupon, $price);
            $amount_before_discount=$price;
            if ($check_coupon['status']) {
                $amount_before_discount=$check_coupon['items']['amount_after_discount_2'];
            }

            //Transfer the balance to the marketer

            $marketer_percentage_check=$course_eloquent->marketerPercentageCheck($coupon, $price);
            if ($marketer_percentage_check['status']) {

                $discount_percentage=$marketer_percentage_check['items']['discount_percentage'];
                $marketer_id=$marketer_percentage_check['items']['marketer_id'];
                $marketer_name=$marketer_percentage_check['items']['marketer_name'];

                // save Transactios
                $params_transactios=[
                    'description'=>"نسبة المسوق $marketer_name من الاشتراك بالدورة $course_title",
                    'user_id'=>$marketer_id,
                    'user_type'=>Transactios::MARKETER,
                    'payment_id'=>uniqid(),
                    'amount'=>$discount_percentage,
                    'amount_before_discount'=>0,
                    'type'=>Transactios::DEPOSIT,
                    'transactionable_id'=>$user_course->id,
                    'transactionable_type'=>get_class($user_course),
                    'coupon'=>$coupon,
                ];

                $this->saveTransactios($params_transactios);


                $student_name=$user_course->user->name;
                $params_balance=[
                    'description'=>"إشتراك الطالب $student_name بالدورة $course_title",
                    'user_id'=>$marketer_id,
                    'user_type'=>Transactios::MARKETER,
                    'transaction_id'=>$user_course->id,
                    'transaction_type'=>get_class($user_course),
                    'amount'=>$discount_percentage,
                    'system_commission'=>0,
                    'amount_before_commission'=>$price,
                    'becomes_retractable_at'=>Carbon::now(),
                    'is_retractable'=>1,
                ];

                $this->addBalance($params_balance);




            }


        }

        // save Transactios
        $params_transactios=[
            'description'=> $course_title,
            'user_id'=>$user_course->user_id,
            'user_type'=>Transactios::LECTURER,
            'payment_id'=>uniqid(),
            'amount'=>$price,
            'amount_before_discount'=>$amount_before_discount,
            'type'=>Transactios::DEPOSIT,
            'transactionable_id'=>$user_course->id,
            'transactionable_type'=>get_class($user_course),
            'coupon'=>$coupon,
        ];

        $this->saveTransactios($params_transactios);

        // add balance to lecturer
        $system_commission = getSystemCommission($course->user_id);

        //amount_before_commission
        $amount_after_commission=$price;
        if ($system_commission!=0) {
            $amount_after_commission=$price - (($system_commission/100)* $price);
        }

        $params_balance=[
            'description'=> $course_title,
            'user_id'=>$user_course->lecturer_id,
            'user_type'=>Balances::LECTURER,
            'transaction_id'=>$user_course->id,
            'transaction_type'=>get_class($user_course),
            'amount'=>$amount_after_commission,
            'system_commission'=>$system_commission,
            'amount_before_commission'=>$price,
            'becomes_retractable_at'=>Carbon::now(),
            'is_retractable'=>1,
        ];

        $this->addBalance($params_balance);

        return true;
    }

    public function saveTransactios(array $params)
    {
        Transactios::create([
            'description'=>$params['description'],
            'user_id'=>$params['user_id'],
            'user_type'=>$params['user_type'],
            'payment_id'=>$params['payment_id'],
            'amount'=>$params['amount'],
            'amount_before_discount'=>$params['amount_before_discount'],
            'type'=>$params['type'],
            'transactionable_id'=>$params['transactionable_id'],
            'transactionable_type'=>$params['transactionable_type'],
            'coupon'=>isset($params['coupon']) ? $params['coupon'] : '',
        ]);

        return '';
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description'=>$params['description'],
            'user_id'=>$params['user_id'],
            'user_type'=>$params['user_type'],
            'type'=>Balances::DEPOSIT,
            'transaction_id'=>$params['transaction_id'],
            'transaction_type'=>$params['transaction_type'],
            'amount'=>$params['amount'],
            'system_commission'=>$params['system_commission'],
            'amount_before_commission'=>$params['amount_before_commission'],
            'becomes_retractable_at'=>$params['becomes_retractable_at'],
            'is_retractable'=>$params['is_retractable'],

        ]);

        // Run Job to change its state to make it draggable

        return true;
    }
}
