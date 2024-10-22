<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{CourseSessionSubscription,CourseSession};

class CourseSessionSubscriptionsController extends Controller
{

    public function subscribe(Request $request)
    {
        $studentSubscribedSessionsIds = auth('web')->user()->studentSubscribedSessions()->pluck('course_session_id')->toArray();

        if($request->type == "group")
        {
           $sessions = CourseSession::where('group_id', $request->target_id)->get();
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
           $session = CourseSession::find($request->target_id);
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
            }else{
                return  $response = [
                    'status_msg' => 'error',
                    'message' => __('lesson_alreay_subscribed'),
                ];
            }
        }

        return  $response = [
            'status_msg' => 'success',
            'message' => __('done_operation'),
        ];
    }

}