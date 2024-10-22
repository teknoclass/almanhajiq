<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Courses;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $course_id = $request->route('course_id');

        if (Auth::guard('web')->check()) {
            $user = auth('web')->user();

            if ($user->role == 'student') {
                $exist = $this->checkStudent($course_id, $user->id);
                if ($exist || in_array($course_id, studentSubscriptionCoursessIds()) || in_array($course_id, studentInstallmentsCoursessIds())) return $next($request);

            }
        }
        return response('Unauthorized. You are not subscribed to this course.', 403);
    }

    public function checkStudent($course_id, $user_id)
    {
        $does_exist = UserCourse::select('id', 'user_id', 'course_id')
        ->where([
            ['user_id', $user_id],
            ['course_id', $course_id]
        ])->first();

        return $does_exist;
    }
}
