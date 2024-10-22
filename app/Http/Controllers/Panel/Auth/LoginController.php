<?php

namespace App\Http\Controllers\Panel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('loggedOut');

    }

    public function showLoginForm()
    {

        return view('panel.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            $device_token=$request->device_token;
            $admin=Admin::findorfail(auth('admin')->user()->id);
            $admin->update(['device_token'=>$device_token]);

            return redirect()->route('panel.home');

        }

        $request->session()->flash('alert-danger',__('login_error'));
        return redirect()->back();



    }




    public function loggedOut(Request $request)
    {
        $this->guard()->logout();

        return redirect('/admin/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}
