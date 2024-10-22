<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\LecturersEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class LecturersController extends Controller
{
    private $lecturers;
    public function __construct(LecturersEloquent $lecturers_eloquent)
    {
        $this->lecturers = $lecturers_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->lecturers->index($request);

        if ($request->ajax()) {
            return View::make('front.lecturers.partials.all', $data)->render();
        }

        return view('front.lecturers.index', $data);
    }

}
