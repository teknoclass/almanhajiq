<?php

namespace App\Http\Controllers\Front\User\Marketer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Front\User\HomeUserEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Front\joinAsMarketRequestRequest;

class HomeController extends Controller
{
    //

    private $home_user;
    public function __construct(HomeUserEloquent $home_user_eloquent)
    {
        $this->home_user = $home_user_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->home_user->index($request,User::MARKETER);

        return view('front.user.home_user.marketer', $data);

    }

    public function joinAsMarketRequest(joinAsMarketRequestRequest $request)
    {
        $response = $this->home_user->joinAsMarketRequest($request);
        return $this->response_api($response['status'], $response['message']);
    }
}
