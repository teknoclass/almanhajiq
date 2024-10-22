<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\MarketersTemplatesRequest;
use App\Repositories\Panel\MarketersTemplatesEloquent;

class MarketersTemplatesController extends Controller
{
    //

    private $marketers_templates;
    public function __construct(MarketersTemplatesEloquent $marketers_templates_eloquent)
    {
        $this->middleware('auth:admin');

        $this->marketers_templates = $marketers_templates_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.marketers_templates.all');
    }


    public function getDataTable()
    {
        return $this->marketers_templates->getDataTable();
    }

    public function create()
    {

        $data = $this->marketers_templates->create();

        return view('panel.marketers_templates.create', $data);
    }

    public function store(MarketersTemplatesRequest $request)
    {


        $response = $this->marketers_templates->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->marketers_templates->edit($id);


        return view('panel.marketers_templates.create', $data);
    }

    public function update($id, MarketersTemplatesRequest $request)
    {
        $response = $this->marketers_templates->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->marketers_templates->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->marketers_templates->operation($request);
        return $this->response_api($response['status'], $response['message']);



    }

}
