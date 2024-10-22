<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\CourseCommentsEloquent;
use App\Http\Requests\Panel\CourseCommentsRequest;
use Illuminate\Http\Request;


class CourseCommentsController extends Controller
{
    //

    private $course_comments;

    public function __construct(CourseCommentsEloquent $course_comments_eloquent)
    {
        $this->middleware('auth:admin');

        $this->course_comments = $course_comments_eloquent;
    }


    public function index(Request $request)
    {
        $data['type']=0;
        return view('panel.course_comments.all',$data);
    }


    public function getDataTable()
    {
        return $this->course_comments->getDataTable();
    }


    public function course(Request $request,$course_id)
    {
        $data['type']=1;
        $data['course_id']=$course_id;
        return view('panel.course_comments.all',$data);

    }


    public function getDataTableCourse($course_id)
    {
        return $this->course_comments->getDataTableCourse($course_id);
    }

    public function create()
    {

        $data = $this->course_comments->create();

        return view('panel.course_comments.create', $data);
    }

    public function edit($id)
    {

        $data = $this->course_comments->edit($id);


        return view('panel.course_comments.create', $data);
    }

    public function update($id, CourseCommentsRequest $request)
    {
        $response = $this->course_comments->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function delete($id)
    {
        $response = $this->course_comments->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->course_comments->operation($request);
        return $this->response_api($response['status'], $response['message']);


    }


}
