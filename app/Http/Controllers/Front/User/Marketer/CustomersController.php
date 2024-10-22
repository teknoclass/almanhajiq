<?php

namespace App\Http\Controllers\Front\User\Marketer;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\Marketer\CustomersEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CustomersController extends Controller
{
    //

    private $customers;


    public function __construct(
        CustomersEloquent $customers_eloquent
    ) {
        $this->customers = $customers_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->customers->all($request);

        if ($request->ajax()) {
            return View::make('front.user.marketer.customers.partials.all', $data)->render();
        }

        return view('front.user.marketer.customers.index', $data);
    }
}
