<?php

namespace App\Repositories;

use App\Models\Notifications;
use App\Models\UserCourse;

class BaseRepository
{
    function notify_registered_users($course_id)
    {
        $user_courses = UserCourse::where('course_id', $course_id)->where('is_end', 1)->get();
        $course_title = $user_courses->first()?->course?->title;
        foreach ($user_courses as $key => $user_course) {
            // notify
            $title                       = 'إضافة محتوي للدورة';
            $text                        = " تم إضافة محتوي للدورة: " . $course_title;
            $notification['title']       = $title;
            $notification['text']        = $text;
            $notification['user_type']   = 'user';
            $notification['action_type'] = 'add_course_requests';
            $notification['action_id']   = $course_id;
            $notification['created_at']  = \Carbon\Carbon::now();

            $notification['user_id'] = $user_course->user_id;

            Notifications::insert($notification);
            sendWebNotification($user_course->user_id, 'user', $title, $text);

            return true;
        }

        UserCourse::where('course_id', $course_id)->where('is_end', 1)->update([
            "is_end" => 0
        ]);
    }

    public function getUser($is_web)
    {
        if ($is_web) {
            $user = auth('web')->user();
        } else {
            $user = auth()->user();
        }
        return $user;
    }
}
