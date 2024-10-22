<?php

namespace App\Repositories\Front\User;

use App\Models\Category;
use App\Models\User;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileSettingsEloquent extends HelperEloquent
{
    public function indexProfile()
    {
        $data['countries']  = Category::getCategoriesByParent('countries')->get();

        $data['languages']  = Category::getCategoriesByParent('course_languages')->get();

        $data['user'] = $this->getUser(true);

        return $data;
    }

    public function updateProfile($request, $is_web = true)
    {

        try {
            $user = $this->getUser($is_web);

            $data = $request->all();

            if ($request->file('file')) {
                //path
                $image = uploadImage($request->all());
                $data['image'] = str_replace('/', '-', $image);
            }

            // if ($request->get('new_password')) {
            //     $new_password = $request->get('new_password');

            //     $data['password'] = Hash::make($new_password);
            //     $data['password_c'] = $new_password;
            // }


            $item = User::updateOrCreate(['id' => $user->id], $data);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;
    }





    public function chnagePassword($request, $is_web = true)
    {
        DB::beginTransaction();

        try {
            $user = $this->getUser($is_web);


            $current_password = $request->get('current_password');
            $new_password = $request->get('new_password');


            //check old password
            if (!Hash::check($current_password, auth('web')->user()->getAuthPassword())) {
                return  $response = [
                    'message' => __('message.worng_current_password'),
                    'status' => false,
                ];
            }

            $item = User::find($user->id);
            $item->password = Hash::make($new_password);
            $item->password_c = $new_password;
            $item->update();


            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;
    }

    /**
     */
    public function __construct()
    {
    }
}
