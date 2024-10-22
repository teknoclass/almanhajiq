<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Courses;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CheckCanPreviewCourseCurriculum
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $course_id = $request->route('course_id');

        // Check the route to define the side of the user (Lecturer / Admin)
        if (Str::contains(request()->url(), 'admin')) {
            $user_type = "admin";
        }
        else if (Str::contains(request()->url(), 'lecturer')) {
            $user_type = "lecturer";
        }

        // Check the accessibility
        if ($user_type == "admin" && Auth::guard('admin')->check()) {
            return $next($request);
        }
        else if ($user_type == "lecturer" && Auth::guard('web')->check()) {
            $user = auth('web')->user();

            if ($user->role == 'lecturer') {
                $exist = $this->checkLecturer($course_id, $user->id);
                if ($exist) return $next($request);
            } else {
                return response('Unauthorized. You can not preview this course.', 403);
            }
        }

        return response('Unauthorized. You can not preview this course.', 403);
    }

    public function checkLecturer($course_id, $user_id)
    {
        $does_exist = Courses::where(['id' => $course_id, 'user_id' => $user_id])->first();

        return $does_exist;
    }
}
