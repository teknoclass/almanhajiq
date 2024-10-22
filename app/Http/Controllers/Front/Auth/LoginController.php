<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SignInRequest;
use App\Repositories\Front\AuthEloquent;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    private $auth;
    public function __construct(AuthEloquent $auth_eloquent)
    {
        $this->middleware('guest:web')->except('logout');

        $this->auth = $auth_eloquent;
    }

    public function index()
    {

        return view('front.auth.login');
    }

    public function login(SignInRequest $request)
    {

        $response = $this->auth->singIn($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function logout(Request $request)
    {
        $response = $this->auth->singout($request);

        return $response;
    }
}
