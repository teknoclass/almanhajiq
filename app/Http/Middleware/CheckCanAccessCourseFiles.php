<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Courses;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCanAccessCourseFiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $course_id = $request->route('course_id');
        $guards = ['admin', 'web'];

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'admin':
                        return $next($request);
                        break;

                    case 'web':
                        $user = auth('web')->user();

                        if ($user->role == 'student') {
                            $exist = $this->checkStudent($course_id, $user->id);
                            if ($exist) return $next($request);

                        } elseif ($user->role == 'lecturer') {
                            $exist = $this->checkLecturer($course_id, $user->id);
                            if ($exist) return $next($request);
                        }

                        break;

                    default:
                        break;
                }
            }
        }
        return response('Unauthorized.', 403);
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

    public function checkLecturer($course_id, $user_id)
    {
        $does_exist = Courses::where(['id' => $course_id, 'user_id' => $user_id])->first();

        return $does_exist;
    }
}
