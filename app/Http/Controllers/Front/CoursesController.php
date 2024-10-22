<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Front\CoursesEloquent;
use Illuminate\Support\Facades\View;

class CoursesController extends Controller
{
    //

    private $courses;
    public function __construct(CoursesEloquent $courses_eloquent)
    {
        $this->courses = $courses_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->courses->index($request);

        if ($request->ajax()) {
            return View::make('front.courses.partials.all-courses', $data)->render();
        }

        return view('front.courses.index', $data);
    }


    public function single($id, $title)
    {
        $data = $this->courses->single($id);

        return view('front.courses.single', $data);
    }

}
