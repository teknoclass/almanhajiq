<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\WithdrawalRequestsEloquent;
use Illuminate\Http\Request;

class WithdrawalRequestsController extends Controller
{
    //
    private $withdrawal_requests;
    public function __construct(WithdrawalRequestsEloquent $withdrawal_requests_eloquent)
    {
        $this->middleware('auth:admin');

        $this->withdrawal_requests = $withdrawal_requests_eloquent;
    }


    public function index(Request $request)
    {
        return view('panel.withdrawal_requests.all');
    }


    public function getDataTable()
    {
        return $this->withdrawal_requests->getDataTable();
    }

    public function view ($id){

        $data= $this->withdrawal_requests->view($id);

        return view('panel.withdrawal_requests.view',$data);
        
    }

    public function update($id, Request $request)
    {
        $response = $this->withdrawal_requests->update($id,$request);

        return $this->response_api($response['status'], $response['message']);
    }



}
