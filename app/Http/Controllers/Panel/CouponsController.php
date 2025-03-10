<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Panel\UsersEloquent;
use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Http\Requests\Panel\CouponsRequest;
use App\Models\Courses;
use App\Repositories\Panel\CouponsEloquent;

class CouponsController extends Controller
{
    //
    private $coupons;
    private $users;

    public function __construct(
        CouponsEloquent $coupons_eloquent,
        UsersEloquent $users_eloquent
    ) {
        $this->middleware('auth:admin');

        $this->coupons = $coupons_eloquent;

        $this->users = $users_eloquent;

    }






    public function index(Request $request)
    {
        $data['users']=$this->users->getAllByRole(User::MARKETER);

        return view('panel.coupons.all',$data);
    }


    public function getDataTable()
    {
        return $this->coupons->getDataTable();
    }

    public function create()
    {

        return view('panel.coupons.create');
    }
    public function store(couponsRequest $request)
    {
        $response = $this->coupons->store($request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function createMultiple()
    {

        return view('panel.coupons.createMulty');
    }
    public function storeMultiple(Request $request)
    {
        $response = $this->coupons->storeMultiple($request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function edit($id)
    {
        $data = $this->coupons->edit($id);


        return view('panel.coupons.create', $data);
    }

    public function update($id, couponsRequest $request)
    {
        $response = $this->coupons->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->coupons->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {
        $response = $this->coupons->operation($request);
        return $this->response_api($response['status'], $response['message']);
    }
}
