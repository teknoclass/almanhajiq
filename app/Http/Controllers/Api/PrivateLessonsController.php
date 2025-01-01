<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\PrivateLessonsEloquent;
use Illuminate\Http\Request;

class PrivateLessonsController extends Controller
{
    protected $private_lessons;

    function __construct(PrivateLessonsEloquent $privateLessonsEloquent)
    {
        $this->private_lessons = $privateLessonsEloquent;
    }

    function get($type){
        $data = $this->private_lessons->indexApi($type,false);


        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message,$data);

    }

    function postpone(Request $request){

        $data = $this->private_lessons->postpone($request);

        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message);


    }

}
