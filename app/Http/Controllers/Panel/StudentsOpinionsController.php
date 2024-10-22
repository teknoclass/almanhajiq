<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\StudentsOpinionsRequest;
use App\Repositories\Panel\StudentsOpinionsEloquent;

class StudentsOpinionsController extends Controller
{
    //
    private $students_opinions;
    public function __construct(StudentsOpinionsEloquent $students_opinions_eloquent)
    {
        $this->middleware('auth:admin');

        $this->students_opinions = $students_opinions_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.students_opinions.all');
    }

    public function getDataTable()
    {
        return $this->students_opinions->getDataTable();
    }

    public function create()
    {

        return view('panel.students_opinions.create');
    }

    public function store(StudentsOpinionsRequest $request)
    {


        $response = $this->students_opinions->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->students_opinions->edit($id);


        return view('panel.students_opinions.create', $data);
    }

    public function update($id, StudentsOpinionsRequest $request)
    {
        $response = $this->students_opinions->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->students_opinions->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
