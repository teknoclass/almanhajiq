<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\AccountVerificationRequest;
use App\Http\Requests\Front\joinAsTeacherRequestRequest;
use App\Repositories\Front\AuthEloquent;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    //

    private $auth;
    public function __construct(AuthEloquent $auth_eloquent)
    {
        // $this->middleware('guest:web')->except('logout');

        $this->auth = $auth_eloquent;
    }

    public function verifyUser()
    {
        return view('front.auth.verify');
    }

    public function verifyLecturer()
    {
        $data = $this->auth->verifyLecturer();

        if ($data['type'] == "email_verification")
            return view('front.auth.verify');

        elseif ($data['type'] == "admin_validation")
            return view('front.auth.joinAsTeacherRequest', $data);
    }

    public function WelcomeLecturer()
    {
        return view('front.auth.joinAsTeacherRequestWelcome');
    }

    public function verifyMarketer()
    {
        $data = $this->auth->verifyMarketer();

        if ($data['type'] == "email_verification")
            return view('front.auth.verify');

        elseif ($data['type'] == "admin_validation")
            return view('front.auth.joinAsMarketerRequest', $data);
    }


    public function joinAsTeacherRequest(joinAsTeacherRequestRequest $request)
    {
        $response = $this->auth->joinAsTeacherRequest($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function verification(AccountVerificationRequest $request)
    {

        $response = $this->auth->accountVerification($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function resend(Request $request)
    {

        $response = $this->auth->resendCode();

        $request->session()->flash($response['alert_class'], $response['message']);

        return redirect()->back();
    }
}
