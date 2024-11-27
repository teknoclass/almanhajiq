<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Api\LecturerStudentProfileEloquent;

class TeacherStudentProfileController extends Controller
{
    private $student_profile;

    function __construct(LecturerStudentProfileEloquent $student_profile_eloquent)
    {
        $this->student_profile = $student_profile_eloquent;
    }

    function index($id){

        $data = $this->student_profile->index($id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function courses($id){

        $data = $this->student_profile->courses($id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

    function comments($id){

        $data = $this->student_profile->comments($id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

}
