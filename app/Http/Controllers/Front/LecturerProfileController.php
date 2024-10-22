<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\LecturerProfileEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LecturerProfileController extends Controller
{
    //

    private $profile;
    public function __construct(LecturerProfileEloquent $profile_eloquent)
    {

        $this->profile = $profile_eloquent;
    }

    public function index($id,$title,Request $request)
    {
        $data                         = $this->profile->index($id,$request);
        return view('front.lecturer_profile.index', $data);
    }

    public function courses($id, Request $request)
    {
        $data = $this->profile->courses($id);

        if ($request->ajax()) {
            return View::make('front.courses.partials.all-courses', $data)->render();
        }

        return view('front.lecturer_profile.partials.courses', $data);
    }

    // public function getMoreCourses($id, Request $request)
    // {

    //     $response = $this->profile->getMoreCourses($id,$request);

    //     return $this->response_api($response['status'], $response['message'],$response['items']);

    // }

    // public function getMoreReviews($id, Request $request)
    // {

    //     $response = $this->profile->getMoreReviews($id,$request);

    //     return $this->response_api($response['status'], $response['message'],$response['items']);

    // }

}
