<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{Courses, UserCourse,Coupons,Balances,Transactios,PaymentDetail};
use App\Services\PaymentService;
use App\Services\ZainCashService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;

class PaymentOperationsController extends Controller
{

    protected PaymentService $paymentService;
    protected ZainCashService $zainCashService;

    public function __construct()
    {
       $this->paymentService = new PaymentService();
       $this->zainCashService = new ZainCashService();
    }

    public function confirmPayment(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $cartId = $request->get('requestId');
            $paymentDetails = Transactios::where('order_id',$cartId)->first();
            if($paymentDetails['place'] == 'web'){

                $userId = auth('web')->user()->id ?? null;
                $paymentDetails = session("payment-$userId");
                $paymentType = $paymentDetails['payment_type'] ?? null;

                if($paymentType == "full")
                {
                    return redirect (url('/user/full-subscribe-course-confirm'));
                }
                elseif($paymentType == "sessions")
                {
                    return redirect(url('/user/subscribe-to-course-sessions-confirm'));
                }
                elseif($paymentType == "installment")
                {
                    return redirect(url('/user/pay-to-course-session-installment-confirm'));
                }
                elseif($paymentType == "private")
                {
                    return redirect(url('/user/private-lesson-confirm'));
                }
            }else{
                if($paymentDetails['payment_type'] == "full")
                {
                    return redirect (url('/api/payment/full-subscribe-course-confirm') . "?requestId=$cartId");
                }
                elseif($paymentDetails['payment_type'] == "session")
                {
                    return redirect(url('/api/payment/subscribe-to-course-sessions-confirm') . "?requestId=$cartId");
                }
                elseif($paymentDetails['payment_type'] == "group")
                {
                    return redirect(url('/api/payment/subscribe-to-course-group-confirm') . "?requestId=$cartId");
                }
                elseif($paymentDetails['payment_type'] == "installment")
                {
                    return redirect(url('/api/payment/pay-to-course-session-installment-confirm') . "?requestId=$cartId");
                }
                elseif($paymentDetails['payment_type'] == "private_lesson")
                {
                    return redirect(url('/api/payment/pay-to-private-lesson-confirm') . "?requestId=$cartId");
                }
            }

            DB::commit();
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

    public function handleWebhook(Request $request)
    {
        DB::beginTransaction();
        try {

            $userId = auth('web')->user()->id ?? null;
            $paymentDetails = session("payment-$userId");
            $paymentType = $paymentDetails['payment_type'] ?? null;

            switch ($paymentType) {
                case 'full':
                    return app(CourseFullSubscriptionsController::class)->handleWebhook($request);
                case 'sessions':
                    return app(CourseSessionSubscriptionsController::class)->handleWebhook($request);
                case 'installment':
                    return app(CourseSessionInstallmentsController::class)->handleWebhook($request);
                case 'private':
                    return app(PrivateLessonSubscriptionsController::class)->handleWebhook($request);
                default:
                    throw new \Exception("Invalid payment type: $paymentType");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }

}
