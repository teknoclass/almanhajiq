<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\OurServicesRequest;
use App\Repositories\Panel\OurServicesEloquent;

class OurServicesController extends Controller
{
    //

    private $our_services;
    public function __construct(OurServicesEloquent $our_services_eloquent)
    {
        $this->middleware('auth:admin');

        $this->our_services = $our_services_eloquent;
    }

    public function index(Request $request)
    {

        return view('panel.our_services.all');
    }

    public function getDataTable()
    {
        return $this->our_services->getDataTable();
    }

    public function create()
    {

        return view('panel.our_services.create');
    }

    public function store(OurServicesRequest $request)
    {


        $response = $this->our_services->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->our_services->edit($id);


        return view('panel.our_services.create', $data);
    }

    public function update($id, OurServicesRequest $request)
    {
        $response = $this->our_services->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->our_services->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }


}
