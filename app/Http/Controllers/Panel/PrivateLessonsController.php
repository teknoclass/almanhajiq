<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\PrivateLessonsRequest;
use App\Repositories\Panel\PrivateLessonsEloquent;


class PrivateLessonsController extends Controller
{
    //
    private $private_lessons;
    public function __construct(PrivateLessonsEloquent $private_lessons_eloquent)
    {
        $this->middleware('auth:admin');

        $this->private_lessons = $private_lessons_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.private_lessons.all');
    }

    public function getDataTable()
    {
        return $this->private_lessons->getDataTable();
    }

    public function create()
    {
        $data = $this->private_lessons->create();
        return view('panel.private_lessons.create',$data);
    }

    public function store(PrivateLessonsRequest $request)
    {


        $response = $this->private_lessons->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->private_lessons->edit($id);


        return view('panel.private_lessons.create', $data);
    }

    public function update($id, PrivateLessonsRequest $request)
    {
        $response = $this->private_lessons->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->private_lessons->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
