<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\Lecturer\CoursesEloquent;
use Illuminate\Http\Request;

class LecturerCourseController extends Controller
{

    private $courses;
    function __construct(CoursesEloquent $courses_eloquent)
    {
        $this->courses = $courses_eloquent;
    }


    function courseStudent(Request $request){

        $data = $this->courses->courseStudent($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }




}
