<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\CourseRatingsEloquent;
use App\Http\Requests\Panel\CourseRatingsRequest;
use Illuminate\Http\Request;


class CourseRatingsController extends Controller
{
    //

    private $course_rating;

    public function __construct(CourseRatingsEloquent $course_rating_eloquent)
    {
        $this->middleware('auth:admin');

        $this->course_rating= $course_rating_eloquent;
    }


    public function index(Request $request)
    {
       $data['type']=0;
        return view('panel.course_ratings.all',$data);
    }


    public function getDataTable()
    {
        return $this->course_rating->getDataTable();
    }

    public function course(Request $request,$course_id)
    {
        $data['type']=1;
        $data['course_id']=$course_id;
        return view('panel.course_ratings.all',$data);

    }


    public function getDataTableCourse($course_id)
    {
        return $this->course_rating->getDataTableCourse($course_id);
    }

    public function create()
    {

        $data = $this->course_rating->create();

        return view('panel.course_ratings.create', $data);
    }

    public function edit($id)
    {

        $data = $this->course_rating->edit($id);


        return view('panel.course_ratings.create', $data);
    }

    public function update($id, CourseRatingsRequest $request)
    {
        $response = $this->course_rating->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function delete($id)
    {
        $response = $this->course_rating->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->course_rating->operation($request);
        return $this->response_api($response['status'], $response['message']);


    }


}
