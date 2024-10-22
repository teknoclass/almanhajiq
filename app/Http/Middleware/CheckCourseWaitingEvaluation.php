<?php

namespace App\Http\Middleware;

use App\Models\Courses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseWaitingEvaluation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $course = Courses::whereId($id)->first();

        if (!@$course) abort(404);

        $status = $course->status;

        switch ($status) {
            case Courses::READY:
                return redirect()->route('user.lecturer.my_courses.waiting_evaluation', $id);
                break;

            default:
                return $next($request);
                break;
        }

    }
}
