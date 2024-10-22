<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\CoursesRequest;
use App\Repositories\Panel\CourseStudentsEloquent;
use App\Http\Requests\Panel\AddStudentCourseRequest;

class CourseStudentsController extends Controller
{
    //

    private $course_students;
    public function __construct(CourseStudentsEloquent $course_students_eloquent)
    {
        $this->middleware('auth:admin');

        $this->course_students = $course_students_eloquent;
    }

    public function index(Request $request)
    {
        $data['type']=0;
        return view('panel.course_students.all',$data);
    }

    public function getDataTable()
    {
        return $this->course_students->getDataTable();
    }

    public function course(Request $request,$course_id)
    {
        $data['type']=1;
        $data['course_id']=$course_id;
        return view('panel.course_students.all',$data);

    }


    public function getDataTableCourse($course_id)
    {
        return $this->course_students->getDataTableCourse($course_id);
    }

    public function create(Request $request)
    {

        return view('panel.course_students.create');
    }

    public function store(AddStudentCourseRequest $request)
    {

        return $this->course_students->store($request);

    }

    public function getCourseInfo(Request $request)
    {
        $response= $this->course_students->getCourseInfo($request);

        return $this->response_api($response['status'], $response['message'], $response['items']);


    }
    
    public function delete($id)
    {
        $response = $this->course_students->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
