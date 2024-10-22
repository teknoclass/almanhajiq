<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForgetPasswordFormRequest;
use App\Http\Requests\Front\ResetPasswordRequest;
use App\Repositories\Front\ForgotPasswordEloquent;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //

    private $forgot_password;
    public function __construct(ForgotPasswordEloquent $forgot_password_eloquent)
    {
        $this->middleware('guest:web');


        $this->forgot_password = $forgot_password_eloquent;
    }


    public function showForgetPasswordForm()
    {
        return view('front.auth.passwords.email');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(ForgetPasswordFormRequest $request)
    {

        $response = $this->forgot_password->sendEmail($request);

        return $this->response_api($response['status'], $response['message']);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token, $email)
    {
        $data['token'] = $token;
        $data['email'] = $email;

        return view('front.auth.passwords.reset', $data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {

        $response = $this->forgot_password->resetPassword($request);

        return $this->response_api($response['status'], $response['message']);



    }
}
