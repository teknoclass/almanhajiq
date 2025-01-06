<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\joinAsMarketRequestRequest;
use App\Repositories\Front\User\HomeUserEloquent;


class MarketerHomeController extends Controller
{
    private $home_user;
    public function __construct(HomeUserEloquent $home_user_eloquent)
    {
        $this->home_user = $home_user_eloquent;
    }


    public function joinAsMarketRequest(joinAsMarketRequestRequest $request)
    {
        $response = $this->home_user->joinAsMarketRequest($request);
        return $this->response_api($response['status'], $response['message']);
    }
}
