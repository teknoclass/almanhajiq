<?php

namespace App\Http\Controllers\Front\User\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\ProfitsWithdrawalRequestRequest;
use App\Models\Balances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\Lecturer\FinancialRecordEloquent as LecturerFinancialRecordEloquent;

class FinancialRecordController extends Controller
{
    //
    private $financial_record;
    public function __construct(LecturerFinancialRecordEloquent $financial_record_eloquent)
    {
        $this->financial_record = $financial_record_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->financial_record->all();

        if ($request->ajax()) {
            return View::make('front.user.lecturer.financial_reports.records.partials.all', $data)->render();
        }

        return view('front.user.lecturer.financial_reports.records.index', $data);
    }

    public function cancelRequest(Request $request)
    {

        $response = $this->financial_record->cancelRequest($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function storeRequest(ProfitsWithdrawalRequestRequest $request)
    {

        $response = $this->financial_record->storeRequest($request);

        return $this->response_api($response['status'], $response['message']);
    }



}
