<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{CourseSessionSubscription,CourseSession,CourseSessionsGroup};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $data['price'] = $request->price;

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
        $response = $this->paymentService->processPayment([
            "amount" => $request->price,
            "currency" => "IQD",
            "finishPaymentUrl" => url('/user/subscribe-to-course-sessions-confirm'),
            "notificationUrl" => url('/user/subscribe-to-course-sessions-confirm'),
        ]);  
      
        if($request->type == "group")
        {
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
        }else{
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
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
                'course_id' => $request->course_id,
                "purchase_type" => $request->type
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
        if($request->type == "group")
        {
            $description = " شراء وحدة " . CourseSessionsGroup::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSessionsGroup";
        }else{
            $description = " شراء جلسة " . CourseSession::find($request->target_id)->title??"";
            $transactionable_type = "App\\Models\\CourseSession";
        }

        $response = $this->zainCashService->processPayment($request->price,
        url('/user/subscribe-to-course-sessions-confirm'), $description);  
      
       
        if(isset($response['id']))
        {
            $paymentDetails = [
                "description" => $description,
                "orderId" => $response['orderId'],
                "payment_id" => $response['id'],
                "amount" => $request->price,
                "transactionable_type" => $transactionable_type,
                "transactionable_id" => $request->target_id,
                "brand" => "zaincash",
                "transaction_id" => $response['referenceNumber'],
                'course_id' => $request->course_id,
                "purchase_type" => $request->type
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