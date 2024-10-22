<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\SlidersRequest;
use App\Repositories\Panel\SlidersEloquent;


class SlidersController extends Controller
{
    private $sliders;
    public function __construct(SlidersEloquent $sliders_eloquent)
    {
        $this->middleware('auth:admin');

        $this->sliders = $sliders_eloquent;
    }


    public function index(Request $request) {

       return view('panel.sliders.all');
    }


    public function getDataTable()
    {
        return $this->sliders->getDataTable();
    }

    public function create($type)
    {
        $data = $this->sliders->create($type);

        return view('panel.sliders.create', $data);
    }

    public function store(SlidersRequest $request)
    {


        $response = $this->sliders->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->sliders->edit($id);
        return view('panel.sliders.create', $data);
    }

    public function update($id, SlidersRequest $request)
    {
        $response = $this->sliders->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->sliders->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
