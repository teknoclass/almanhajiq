<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Front\User\AssignmentsEloquent;


class AssignmentController extends Controller
{
    private $assignment;

    public function __construct(AssignmentsEloquent $assignment_eloquent)
    {
        $this->assignment = $assignment_eloquent;
    }

    public function start(Request $request, $id)
    {
        $data = $this->assignment->start($request,null, $id,false);
        $status = true;
        $message = '' ;
        if (@$data['error'] == 'assignment_done')
        {
            $message = __('message.assignment_done');
            $status = false;
        }
        if (@$data['error'] == 'assignment_time_passed')
        {
            $message = __('message.assignment_time_passed');
            $status = false;
        }

        return $this->response_api($status,$message,$data);

    }


    public function uploadFile(Request $request, $course_id)
    {
        $response = $this->assignment->uploadFile($request, $course_id , true);

        return $response;
    }

    function submitAnswer(Request $request)
    {
        $response = $this->assignment->submitAnswer($request,false);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$response);
    }

    function endAssignmentApi(Request $request)
    {
        $data = $this->assignment->endAssignmentApi($request,false);


        return $this->response_api($data['status'],$data['message']);
    }

    function showResults($id){
        $data = $this->assignment->showResult($id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }
}
