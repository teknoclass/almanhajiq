<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\AddCourseRequestsEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\JoinAsTeacherRequestsRequest;
use App\Models\{User,Courses};

class AddCourseRequestsController extends Controller
{
    //

    private $add_course_requests_eloquent;
    public function __construct(AddCourseRequestsEloquent $add_course_requests_eloquent)
    {
        $this->middleware('auth:admin');

        $this->add_course_requests_eloquent= $add_course_requests_eloquent;
    }


    public function index(Request $request) {

        $data['courses'] = Courses::select('id')->with('translations:courses_id,title,locale')->get();
        $data['lecturers'] = User::where('role','lecturer')->select('id','name')->get();

       return view('panel.add_course_requests.all',$data);
    }


    public function getDataTable()
    {
        return $this->add_course_requests_eloquent->getDataTable();
    }


    public function edit($id)
    {

        $data = $this->add_course_requests_eloquent->edit($id);


        return view('panel.add_course_requests.view', $data);
    }

    public function update($id, Request $request)
    {

        $response = $this->add_course_requests_eloquent->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->add_course_requests_eloquent->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
