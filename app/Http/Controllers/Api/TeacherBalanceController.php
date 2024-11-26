<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\Lecturer\FinancialRecordEloquent;

use Illuminate\Http\Request;

class TeacherBalanceController extends Controller
{
    private $balance;

    function __construct(FinancialRecordEloquent $financial_record_eloquent)
    {
        $this->balance = $financial_record_eloquent;
    }

    function index(Request $request){
        $data = $this->balance->all(false,$request);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function send(Request $request){
        $data = $this->balance->storeRequest($request,false);

        return $this->response_api($data['status'],$data['message']);
    }

    function cancel(Request $request){
        $data = $this->balance->cancelRequest($request,false);

        return $this->response_api($data['status'],$data['message']);

    }


}
