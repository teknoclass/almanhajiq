<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\PrivateLessonsEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class PrivateLessonsController extends Controller
{
    private $lecturers;
    public function __construct(PrivateLessonsEloquent $lecturers_eloquent)
    {
        $this->lecturers = $lecturers_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->lecturers->index($request);

        if ($request->ajax()) {
            return View::make('front.private_lessons.partials.all', $data)->render();
        }

        return view('front.private_lessons.index', $data);
    }

}
