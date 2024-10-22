<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\FaqsRequest;
use App\Repositories\Panel\FaqsEloquent;


class FaqsController extends Controller
{
    private $faqs;
    public function __construct(FaqsEloquent $faqs_eloquent)
    {
        $this->middleware('auth:admin');

        $this->faqs = $faqs_eloquent;
    }


    public function index(Request $request) {

       return view('panel.faqs.all');
    }


    public function getDataTable()
    {
        return $this->faqs->getDataTable();
    }

    public function create()
    {

        return view('panel.faqs.create');
    }

    public function store(FaqsRequest $request)
    {


        $response = $this->faqs->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->faqs->edit($id);


        return view('panel.faqs.create', $data);
    }

    public function update($id, FaqsRequest $request)
    {
        $response = $this->faqs->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->faqs->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
