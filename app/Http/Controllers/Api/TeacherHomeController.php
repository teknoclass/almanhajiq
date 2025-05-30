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

    function getStudents(Request $request){
        $data = $this->home->getStudents($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function courseFilter(Request $request){
        $data = $this->home->courseFilter(false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function profile(Request $request){
        $data = $this->home->profile($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function calendar(Request $request){
        $data = $this->home->calendar($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }




}
