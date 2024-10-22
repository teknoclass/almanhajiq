<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SignUpRequest;
use App\Repositories\Front\AuthEloquent;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    //
    private $auth;
    public function __construct(AuthEloquent $auth_eloquent)
    {
        $this->middleware('guest:web');

        $this->auth = $auth_eloquent;
    }

    public function registerStudent()
    {
        $data = $this->auth->registerStudent();

        return view('front.auth.register', $data);
    }

    public function registration(SignUpRequest $request)
    {
        $response = $this->auth->singUp($request);

        return $this->response_api($response['status'] , $response['message'] , NULL , @$response['redirect_url']);
    }

     public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
       $user = Socialite::driver('google')->user();
       $this->_registerOrLoginUser($user , 'google');
       return redirect()->route('user.home.index');
    }

    protected function _registerOrLoginUser($data , $website) {
        $this->auth->_registerOrLoginUser($data ,  $website);
    }
}
