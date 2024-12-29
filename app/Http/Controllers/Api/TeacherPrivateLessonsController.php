<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\Lecturer\LecturerPrivateLessonsEloquent;
use Illuminate\Http\Request;

class TeacherPrivateLessonsController extends Controller
{
    protected $private_lessons;

    function __construct(LecturerPrivateLessonsEloquent $private_eloquent)
    {
        $this->private_lessons = $private_eloquent;
    }

    function get($type){

        $data = $this->private_lessons->indexApi($type,false);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }
}
