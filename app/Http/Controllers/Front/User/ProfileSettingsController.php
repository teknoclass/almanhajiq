<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\ChangePasswordRequest;
use App\Http\Requests\Front\User\UpdateProfileRequest;
use App\Repositories\Front\User\ProfileSettingsEloquent;
use Illuminate\Http\Request;

class ProfileSettingsController extends Controller
{
    //

    private $profile;
    public function __construct(ProfileSettingsEloquent $profile_eloquent)
    {

        $this->profile = $profile_eloquent;
    }

    public function indexProfile(Request $request)
    {

        $data = $this->profile->indexProfile();

        return view('front.user.profile.edit', $data);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $response = $this->profile->updateProfile($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function indexParent(Request $request)
    {
        if(getUser()->role != "student")
        {
            return redirect(url('/user/home'));
        }
        
        $data = $this->profile->indexParent();

        return view('front.user.profile.edit_parent', $data);
    }

    public function updateParent(Request $request)
    {
        $response = $this->profile->updateParent($request);

        return $this->response_api($response['status'], $response['message']);
    }

    // public function indexChangePassword(Request $request)
    // {

    //     $data['user'] = auth('web')->user();

    //     return view('front.user.profile.change_password', $data);
    // }

    public function chnagePassword(ChangePasswordRequest $request)
    {

        $response = $this->profile->chnagePassword($request);

        return $this->response_api($response['status'], $response['message']);
    }
}
