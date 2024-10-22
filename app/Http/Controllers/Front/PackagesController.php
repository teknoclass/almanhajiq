<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Front\PackagesEloquent;
use Illuminate\Support\Facades\View;

class PackagesController extends Controller
{
    //

    private $packages;
    public function __construct(PackagesEloquent $packages_eloquent)
    {
        $this->packages = $packages_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->packages->index($request);

        if ($request->ajax()) {
            return View::make('front.packages.partials.all-packages', $data)->render();
        }

        return view('front.packages.index', $data);
    }


    public function single($id, $title)
    {
        $data = $this->packages->single($id);

        return view('front.packages.single', $data);
    }

}
