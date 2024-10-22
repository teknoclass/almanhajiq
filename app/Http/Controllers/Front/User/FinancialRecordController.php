<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\ProfitsWithdrawalRequestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\FinancialRecordEloquent;

class FinancialRecordController extends Controller
{
    //
    private $financial_record;
    public function __construct(FinancialRecordEloquent $financial_record_eloquent)
    {
        $this->financial_record = $financial_record_eloquent;
    }

    public function index($user_type,Request $request)
    {
        $data = $this->financial_record->all($user_type);

        if ($request->ajax()) {
            return View::make('front.user.financial_record.partials.all', $data)->render();
        }

        return view('front.user.financial_record.index', $data);
    }

    public function cancelRequest($user_type,Request $request)
    {

        $response = $this->financial_record->cancelRequest($request,$user_type);

        return $this->response_api($response['status'], $response['message']);
    }

    public function storeRequest($user_type,ProfitsWithdrawalRequestRequest $request)
    {

        $response = $this->financial_record->storeRequest($request,$user_type);

        return $this->response_api($response['status'], $response['message']);
    }



}
