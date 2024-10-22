<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\PackagesEloquent;

class PackagesController extends Controller
{
    //

    private $packages;

    public function __construct(PackagesEloquent $packages_eloquent)
    {
        $this->packages = $packages_eloquent;
    }


    public function index(Request $request, $type = 'upcoming')
    {

        $data = $this->packages->index($type , is_paid_only:true);

        if ($request->ajax()) {
            return View::make('front.user.packages.partials.all', $data)->render();
        }

        return view('front.user.packages.index', $data);
    }

    public function book(Request $request, $id)
    {
        $response = $this->packages->book($request, $id);

        return response()->json($response);
    }

}
