<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PrivateLessons;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateLessonPosponeRequestCollection;
use App\Repositories\Front\User\Lecturer\LecturerPrivateLessonsEloquent;

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

    function createOrJoin($id){
        $lesson = PrivateLessons::find($id);
        if($lesson->meeting_link == null){
            $url = $lesson->createLiveSession('api');
        }else{
            $url = $lesson->joinLiveSessionV2('api');
        }



        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$url);


    }

    function getRequests(){
        $data = $this->private_lessons->getRequests();

        $data = new PrivateLessonPosponeRequestCollection($data);

        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message,$data);
    }
}
