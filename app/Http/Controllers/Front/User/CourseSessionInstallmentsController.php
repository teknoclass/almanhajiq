<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;
use App\Models\{StudentSessionInstallment,CourseSession};

class CourseSessionInstallmentsController extends Controller
{

    public function pay(Request $request)
    {
        StudentSessionInstallment::updateOrCreate([
            'student_id' => auth('web')->user()->id,
            'course_id' => $request->course_id,
            'access_until_session_id' => $request->id,
        ]);
    
        return  $response = [
            'status_msg' => 'success',
            'message' => __('done_operation'),
        ];
    }
}