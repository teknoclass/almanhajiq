<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UsersRequest;
use App\Repositories\Panel\UsersEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\UserRequest;

class UsersController extends Controller
{
    private $users;
    public function __construct(UsersEloquent $users_eloquent)
    {
        $this->middleware('auth:admin');

        $this->users = $users_eloquent;
    }


    public function index(Request $request)
    {

        $data['title']=__('users');
        $roles = $this->users->getAllRoles();
        $data['roles'] = $roles;
        return view('panel.users.all',$data);
    }


    public function getDataTable()
    {
        return $this->users->getDataTable();
    }
//
//    public function lecturers(Request $request)
//    {
//        $data['title']=__('trainers');
//        $data['type']=2;
//        return view('panel.users.all',$data);
//    }
//    public function getDataTableLecturers()
//    {
//        return $this->users->getDataTableLecturers();
//    }
//
//    public function students(Request $request)
//    {
//        $data['title']=__('students');
//        $data['type']=3;
//        return view('panel.users.all',$data);
//    }
//
//    public function getDataTableStudents()
//    {
//        return $this->users->getDataTableStudents();
//    }
//
//    public function marketers(Request $request)
//    {
//        $data['title']=__('marketers');
//        $data['type']=4;
//        return view('panel.users.all',$data);
//    }
//
//    public function getDataTableMarketers()
//    {
//        return $this->users->getDataTableMarketers();
//    }

    public function create()
    {
        $data = $this->users->create();

        return view('panel.users.create', $data);
    }

    public function store(UsersRequest $request)
    {

        $response = $this->users->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->users->edit($id);


        return view('panel.users.create', $data);
    }

    public function update($id, UsersRequest $request)
    {
        $response = $this->users->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->users->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->users->operation($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function exportExcel(Request $request)
    {
        return $this->users->exportExcel($request);
    }

    public function searchStudents(Request $request){

        return $this->users->searchStudents($request);
    }

    public function searchLecturers(Request $request){

        return $this->users->searchLecturers($request);
    }

    public function searchMarketers(Request $request){

        return $this->users->searchMarketers($request);
    }

}
