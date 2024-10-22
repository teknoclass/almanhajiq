<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\FaqsEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FaqsController extends Controller
{
    //

    private $faqs;
    public function __construct(FaqsEloquent $faqs_eloquent)
    {

        $this->faqs = $faqs_eloquent;
    }

    public function index(Request $request)
    {

        $data = $this->faqs->index();

        if ($request->ajax())
        {
            return View::make('front.faqs.partials.all', $data)->render();
        }

        return view('front.faqs.index', $data);
    }
}
