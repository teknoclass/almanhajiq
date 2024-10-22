<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\CourseRatingsEloquent;
use App\Http\Requests\Panel\CourseRatingsRequest;
use App\Repositories\Panel\PrivateLessonRatingsEloquent;
use Illuminate\Http\Request;


class PrivateLessonRatingsController extends Controller
{
    //

    private $private_lesson_ratins;

    public function __construct(PrivateLessonRatingsEloquent $private_lesson_rating_eloquent)
    {
        $this->middleware('auth:admin');

        $this->private_lesson_ratins= $private_lesson_rating_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.private_lesson_ratings.all');
    }


    public function getDataTable()
    {
        return $this->private_lesson_ratins->getDataTable();
    }

    public function create()
    {

        $data = $this->private_lesson_ratins->create();

        return view('panel.private_lesson_ratings.create', $data);
    }

    public function edit($id)
    {

        $data = $this->private_lesson_ratins->edit($id);


        return view('panel.private_lesson_ratings.create', $data);
    }

    public function update($id, CourseRatingsRequest $request)
    {
        $response = $this->private_lesson_ratins->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function delete($id)
    {
        $response = $this->private_lesson_ratins->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->private_lesson_ratins->operation($request);
        return $this->response_api($response['status'], $response['message']);


    }


}
