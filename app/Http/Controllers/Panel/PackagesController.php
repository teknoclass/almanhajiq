<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\PackagesRequest;
use App\Repositories\Panel\PackagesEloquent;


class PackagesController extends Controller
{
    //
    private $packages;
    public function __construct(PackagesEloquent $packages_eloquent)
    {
        $this->middleware('auth:admin');

        $this->packages = $packages_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.packages.all');
    }

    public function getDataTable()
    {
        return $this->packages->getDataTable();
    }

    public function create()
    {
        return view('panel.packages.create');
    }

    public function store(PackagesRequest $request)
    {


        $response = $this->packages->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->packages->edit($id);


        return view('panel.packages.create', $data);
    }

    public function update($id, PackagesRequest $request)
    {
        $response = $this->packages->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->packages->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
