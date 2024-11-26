<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Api\LecturerHomeEloquent;

class TeacherHomeController extends Controller
{

    private $home;
    function __construct(LecturerHomeEloquent $home_eloquent)
    {
        $this->home = $home_eloquent;
    }

    function getChart(Request $request){

        $data = $this->home->getChart($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function getData(Request $request){
        $data = $this->home->getData($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

    function incomingSessions(Request $request){
        $data = $this->home->getIncomingSession($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }



}
