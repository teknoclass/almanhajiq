<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\MarketersJoiningRequestsRequest;
use App\Repositories\Panel\CouponsEloquent;
use App\Repositories\Panel\MarketersJoiningRequestsEloquent;
use Illuminate\Http\Request;

class MarketersJoiningRequestsController extends Controller
{
    //
    private $marketers_joining_requests;

    private $coupons;

    public function __construct(
        MarketersJoiningRequestsEloquent $marketers_joining_requests_eloquent,
        CouponsEloquent  $coupons_eloquent
    ) {
        $this->middleware('auth:admin');

        $this->marketers_joining_requests = $marketers_joining_requests_eloquent;

        $this->coupons=$coupons_eloquent;
    }


    public function index(Request $request)
    {

        $data=$this->marketers_joining_requests->index();


        return view('panel.marketers_joining_requests.all', $data);
    }


    public function getDataTable()
    {
        return $this->marketers_joining_requests->getDataTable();
    }




    public function edit($id)
    {

        $data = $this->marketers_joining_requests->edit($id);

        $data['coupons']=$this->coupons->getAllGeneral();

        return view('panel.marketers_joining_requests.view', $data);
    }

    public function update($id, MarketersJoiningRequestsRequest $request)
    {
        $response = $this->marketers_joining_requests->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->marketers_joining_requests->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }


}
