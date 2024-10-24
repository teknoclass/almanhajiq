<?php

namespace App\Repositories;

use App\Models\Courses;
use App\Models\CourseSession;
use App\Models\CourseSessionSubscription;
use App\Models\User;

class LiveSessionRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new CourseSession());
    }

    public function getCourseSessionsGroups($id, $user)
    {
        $groups = Courses::where('id', $id)
                         ->with('groups')
                         ->get()
                         ->pluck('groups')
                         ->first()
                         ->unique('id');

        if ($groups) {
            return $groups->map(function ($group) use ($id, $user) {
                if ($user) {
                    $subscription = CourseSessionSubscription::where('related_to_group_subscription', 1)
                                                             ->where([
                                                                 'student_id' => $user->id,
                                                                 'course_id' => $id,
                                                                 'course_session_group_id' => $group->id,
                                                             ])->first();

                    $group->subscription = $subscription;
                }

                return $group;
            });
        }

        return collect();
    }


    public function getCourseSessions($id,$user){

        $sessions =  Courses::where('id',$id)->with('sessions')->get()->pluck('sessions')->first()->unique('id');
        if ($sessions) {
            return $sessions->map(function ($session) use ($id, $user) {
                if ($user) {
                    $subscription = CourseSessionSubscription::where('related_to_group_subscription', 0)
                                                             ->where([
                                                                 'student_id' => $user->id,
                                                                 'course_id' => $id,
                                                                 'course_session_id' => $session->id,
                                                             ])->first();

                    $session->subscription = $subscription;
                }

                return $session;
            });
        }

        return collect();
    }


}
