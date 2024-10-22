<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\WorkStepRequest;
use App\Repositories\Panel\WorkStepsEloquent;


class WorkStepsController extends Controller
{
    private $work;
    public function __construct(WorkStepsEloquent $work_eloquent)
    {
        $this->middleware('auth:admin');

        $this->work = $work_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.work_steps.all');
    }


    public function getDataTable()
    {
        return $this->work->getDataTable();
    }

    public function create()
    {
        return view('panel.work_steps.create');
    }

    public function store(WorkStepRequest $request)
    {


        $response = $this->work->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->work->edit($id);


        return view('panel.work_steps.create', $data);
    }

    public function update($id, WorkStepRequest $request)
    {
        $response = $this->work->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->work->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }
}
