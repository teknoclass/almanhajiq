<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admins;
use App\Models\Transactios;
use App\Models\UserCourse;
use App\Models\CourseSession;
use App\Models\CourseSessionsGroup;
use App\Models\StudentSessionInstallment;
use App\Models\CourseSessionSubscription;
use App\Services\PaymentService;
use Exception;

class RefundsController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->paymentService = new PaymentService();
    }

    public function makeRefund($transaction_id,Request $request)
    {
        
        $transaction = Transactios::find($transaction_id);

        if (!$transaction || ! isRefundableTransaction($transaction_id)) {
            return response()->json(['success' => false, 'message' => 'لا يمكن استرجاع هذه العملية',"status" => "error"]);
        }

        DB::beginTransaction();
        try
        {
           
            $paymentId = $transaction->payment_id;

            $statusCheck = $this->paymentService->checkPaymentStatus($paymentId);

            if($statusCheck["status"] != "SUCCESS")
            {
                return response()->json(['success' => false, 'message' => "رقم العملية غير صحيح","status" => "error"]);
            }
            
            //delete related target
            if($transaction->transactionable_type == "App\\Models\\Courses")
            {
                $item = UserCourse::where('course_id',$transaction->transactionable_id)->where('user_id',$transaction->user_id)->first();
                $course_id = $transaction->transactionable_id;
                if(! $course_id)
                {
                    return response()->json(['success' => false, 'message' => __("course_not_found"),"status" => "error"]);
                }

                $item->delete();
            }
            elseif($transaction->transactionable_type == "App\\Models\\CourseSession")
            {
                $checkIsInstallment = StudentSessionInstallment::where('access_until_session_id',$transaction->transactionable_id)->where('student_id',$transaction->user_id)->first();
                $checkIsOffer = CourseSessionSubscription::where('course_session_id',$transaction->transactionable_id)->where('student_id',$transaction->user_id)->first();   
                if($checkIsInstallment)
                {
                    $item = $checkIsInstallment;
                }else{
                    $item = $checkIsOffer;
                }
                $course_id = $item->course_id;
                if(! $course_id)
                {
                    return response()->json(['success' => false, 'message' => __("course_not_found"),"status" => "error"]);
                }
                $course_id = $item->course_id;
                if(! $course_id)
                {
                    return response()->json(['success' => false, 'message' => __("course_not_found"),"status" => "error"]);
                }

                $item->delete();
            }
            elseif($transaction->transactionable_type == "App\\Models\\CourseSessionsGroup" )
            {
                $item = CourseSessionSubscription::where('course_session_group_id',$transaction->transactionable_id)
                ->where('student_id',$transaction->user_id)
                ->first();
                $course_id = $item->course_id;
                if(! $course_id)
                {
                    return response()->json(['success' => false, 'message' => __("course_not_found"),"status" => "error"]);
                }
                $item = CourseSessionSubscription::where('course_session_group_id',$transaction->transactionable_id)
                ->where('student_id',$transaction->user_id)
                ->delete();
            }

            //make refund transaction
            $response = $this->paymentService->makeRefund($paymentId);
            if(isset($response['error']['code']) && $response['error']['code'] == 18)
            {
                return response()->json(['success' => false, 'message' => "تم استرجاع العملية من قبل","status" => "error"]);   
            }
            elseif(isset($response['error']['code']))
            {
                $desc = isset($response['description']) ? $response['description'] : "";
                return response()->json(['success' => false, 'message' => "تم رفض العملية " .$desc,"status" => "error"]);
            }
            elseif(!isset($response['status']) || $response['status'] != "SUCCESS")
            {
                return response()->json(['success' => false, 'message' => "تم رفض العملية ","status" => "error"]);
            }

            //make transaction
            $paymentDetails = [
                "description" => ' استرجاع '. $transaction->description,
                "orderId" => $response['requestId'],
                "payment_id" => $response['paymentId'],
                "refund_id" => $response['refundId'],
                "amount" =>  $transaction->amount,
                "transactionable_type" => $transaction->transactionable_type,
                "transactionable_id" => $transaction->transactionable_id,
                "brand" => "card",
                'course_id' => @$course_id ?? "",
                "purchase_type" => $transaction->purchase_type,
                "user_id" => $transaction->user_id,
                "type" => "withdrow",
                "is_refunded" => 1
            ];

            $this->paymentService->createTransactionRecord($paymentDetails);

            $this->paymentService->storeBalance($paymentDetails);

            //update transaction
            $transaction->is_refunded = 1;
            $transaction->refund_id = isset($response['refundId']) ? $response['refundId'] : "";
            $transaction->save();

            DB::commit(); 
            return response()->json(['success' => true, 'message' => __('done_operation'),"status" => "success"]);
        } catch (\Exception $e) {
            dd($e->getLine().$e->getMessage());
            DB::rollback(); 
            \Log::error($e->getMessage());
            \Log::error($e->getLine());
            return response()->json(['success' => false, 'message' => __('message.unexpected_error'),"status" => "error"]);
        }

    }

}