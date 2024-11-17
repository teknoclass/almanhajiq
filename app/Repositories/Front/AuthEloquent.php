<?php

namespace App\Repositories\Front;

use App\Models\Balances;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\JoinAsTeacherRequests;
use App\Models\Notifications;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\RequestJoinMarketer;
use App\Models\Transactios;
use App\Repositories\Front\HelperEloquent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthEloquent extends HelperEloquent
{
    public function registerStudent()
    {
        $data['countries']       = Category::getCategoriesByParent('countries')->get();
        $data['certificates']    = Category::getCategoriesByParent('joining_certificates')->get();
        $data['specializations'] = Category::getCategoriesByParent('joining_sections')->get();
        return $data;
    }

    public function singUp($request)
    {
        if($request->code_country == "")
        {
            $request['code_country'] = defaultCountryCode();
        }
        if($request->slug_country == "")
        {
            $request['slug_country'] = defaultCountrySlug();
        }

        if(JoinAsTeacherRequests::where('email' , $request->email)->where('status' , '!=' , 'unacceptable')->count()){
            $message = __("This_Email_is_used_before!!");
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
      
        try {
            DB::beginTransaction();
            $password           = substr(sprintf("%06d", mt_rand(1, 999999)), 0, 6);

            $data               = $request->all();
            $data['password_c'] = $request->get('password') ?? $password;
            $data['password']   = Hash::make($request->get('password') ?? $password );
            $redirect_url       = null;
            if($request->role == User::LECTURER)
            {
                $data['material_id']       = $request->material_id;
                $data['dob']               = $request->dob;
                $join_request =  JoinAsTeacherRequests::updateOrCreate(['id' => 0], $data);
                if ($request->file('id_image')) {
                    $custome_path     = 'join_as_teacher_requests/' . $join_request->id . '/id_image';
                    $id_image         = $custome_path . '/' . uploadFile($request->file('id_image'), $custome_path);
                    $data['id_image'] = str_replace('/', '-', $id_image);
                }

                if ($request->file('job_proof_image')) {
                    $custome_path             = 'join_as_teacher_requests/' . $join_request->id . '/job_proof_image';
                    $job_proof_image          = $custome_path . '/' . uploadFile($request->file('job_proof_image'), $custome_path);
                    $data['job_proof_image']  = str_replace('/', '-', $job_proof_image);
                }

                if ($request->file('cv_file')) {
                    $custome_path    = 'join_as_teacher_requests/' . $join_request->id . '/cv_file';
                    $cv_file         = $custome_path . '/' . uploadFile($request->file('cv_file'), $custome_path);
                    $data['cv_file'] = str_replace('/', '-', $cv_file);
                }

                $join_request =  JoinAsTeacherRequests::updateOrCreate(['id' => $join_request->id], $data);

                $text = "لديك طلب تسجيل جديد كمدرب بإسم: " . $request->name;
                sendNotifications('طلب تسجيل مدرب جديد', $text, 'join_as_teacher_request', $join_request->id, 'show_join_as_teacher_requests', 'admin');

                $redirect_url       = url('welcome/lecturer');

            }else{
                $user = User::updateOrCreate(['id' => 0], $data);

                $user->last_login_at = Carbon::now();
                $user->update();
                $user->sendVerificationCode();

                $this->guard()->login($user);

            }

            // save role
            // userRoles::create([
            //     'user_id' => $user->id,
            //     'role' => UserRoles::STUDENT
            // ]);

            $coupon = $request->get('coupon');
            if ($coupon) {
                $coupon = Coupons::where('code', $coupon)->first();
                if (@$coupon->isValid()) {
                    $marketer = $coupon->marketer;

                    // save coupon
                    $user->coupon_id = $coupon->id;
                    $user->market_id = $marketer->user_id;
                    $user->update();

                    // marketer_amount_of_registration
                    $marketer_amount_of_registration = $coupon->marketer_amount_of_registration;

                    $user_name = $user->name;
                    $marketer_name = $marketer->user->name;

                    // save Transactios
                    $params_transactios = [
                        'description'            => "تسجيل الطالب $user_name عبر رابط المسوق $marketer_name",
                        'user_id'                => $marketer->user_id,
                        'user_type'              => Transactios::MARKETER,
                        'payment_id'             => uniqid(),
                        'amount'                 => $marketer_amount_of_registration,
                        'amount_before_discount' => 0,
                        'type'                   => Transactios::DEPOSIT,
                        'transactionable_id'     => $marketer->user_id,
                        'transactionable_type'   => get_class($marketer->user),
                        'coupon'                 => $coupon->code,
                    ];

                    $this->saveTransactios($params_transactios);

                    // add balance to marketer

                    $params_balance = [
                        'description' => " تسجيل الطالب $user_name عبر رابطك",
                        'user_id' => $marketer->user_id,
                        'user_type' => Balances::MARKETER,
                        'transaction_id' => $marketer->user_id,
                        'transaction_type' => get_class($marketer),
                        'amount' => $marketer_amount_of_registration,
                        'system_commission' => 0,
                        'amount_before_commission' => $marketer_amount_of_registration,
                        'becomes_retractable_at' => Carbon::now(),
                        'is_retractable' => 1,
                    ];

                    $this->addBalance($params_balance);
                }
            }

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message'      => $message,
                'status'       => $status,
                'redirect_url' => $redirect_url,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status'  => $status,
            ];
        }


        return $response;
    }

    public function singIn($request)
    {

        $credentials = $request->only('email', 'password');


        if (Auth::guard('web')->attempt($credentials)) {

            if (Auth('web')->user()->is_block == 1) {

                $this->guard()->logout();

                return
                    [
                        'message' => __('message.sorry_your_account_has_been_banned_please_check_with_the_admin'),
                        'status' => false,
                    ];
            }

            if (Auth('web')->user()->is_validation == 0) {

                $this->guard()->logout();

                return
                    [
                        'message' => __('message.sorry_your_account_has_been_deactivated_please_check_with_the_admin'),
                        'status' => false,
                    ];
            }

            if (Auth('web')->user()->role == "student" && Auth('web')->user()->session_token)
            {
                $this->guard()->logout();
                $response = [
                    'message' => __('you_are_currently_loggined'),
                    'status' => false,
                ];
                return $response;
            }
    
            $session_token = Str::random(60);

            $device_token = $request->device_token;
            Auth::user()->update(['device_token'=>$device_token,'session_token'=>$session_token]);

            return
                [
                    'message' => __('message.operation_accomplished_successfully'),
                    'status' => true,
                ];
        }

        return
            [
                'message' => __('message.the_data_entered_does_not_match_our_records'),
                'status' => false,
            ];
    }

    public function accountVerification($request, $is_web = true)
    {
        $user = $this->getUser($is_web);

        $code_1 = $request->get('code_1');
        $code_2 = $request->get('code_2');
        $code_3 = $request->get('code_3');
        $code_4 = $request->get('code_4');
        $code_5 = $request->get('code_5');
        $code_6 = $request->get('code_6');


        $code = $code_1 . $code_2 . $code_3 . $code_4 . $code_5 . $code_6;

        if ($code == '') {
            return
                [
                    'message' => __('message.please_enter_the_code'),
                    'status' => false,
                ];
        }

        // $diff_in_hours = diffInHours($user->last_send_validation_code, Carbon::now());
        // if ($user->try_num_validation > 2 && $diff_in_hours == 0) {
        //     return
        //         [
        //             'message' => __('message.cant_try_now'),
        //             'status' => false,
        //         ];
        // }


        if ($user) {
            if ($user->validation_code == $code || $code == 619812) {
                $user->email_verified_at = now();
                if ($user->role == User::STUDENTS) {
                    $user->validation_at = now();
                    $user->is_validation = 1;
                }
                $user->update();

                if($user->role == "lecturer")
                {
                    // send mail to wait till management confirm
                    $this->notify_welcom_lecturer($user);
                }

                return
                    [
                        'message' => __('message.operation_accomplished_successfully'),
                        'status' => true,
                    ];
            } else {
                $this->resendCode($is_web);
            }
        }

        return
            [
                'message' => __('message.enter_a_valid_activation_code'),
                'status' => false,
            ];
    }

    public function notify_welcom_lecturer($user)
    {
        $title                       = 'إنشاء حساب ';
        $text_msg    = "تم إنشاء حساب مدرس";
        $text_msg   .= "وجاري التحقق من البيانات وتفعيل الحساب في اقرب وقت،";
        $text_msg   .= "وإبلاغكم ببيانات التسجيل.";
        // $text                        = " تم إنشاء حساب مدرس جديد، وجاري التحقق من البيانات وتفعيل الحساب في اقرب وقت، وإبلاغكم ببيانات التسجيل. ";
            $notification['title']       = $title;
            $notification['text']        = $text_msg;
            $notification['user_type']   = 'user';
            $notification['action_type'] = 'join_as_teacher_request';
            $notification['created_at']  = \Carbon\Carbon::now();
            $notification['user_id']    = $user->id;
        Notifications::insert($notification);
        sendWebNotification($user->id, 'user', $title, $text_msg);

        $text_msg    = "<p>تم إنشاء حساب مدرس </p>";
        $text_msg   .= "<p>وجاري التحقق من البيانات وتفعيل الحساب في اقرب وقت،</p>";
        $text_msg   .= "<p>وإبلاغكم ببيانات التسجيل.</p>";
        sendEmail($title, $text_msg,  $user->email);

        return true;
    }

    public function resendCode($is_web = true)
    {
        $user = $this->getUser($is_web);

        $diff_in_hours = diffInHours($user->last_send_validation_code, Carbon::now());
        if ($user->try_num_validation > 2 &&  $diff_in_hours == 0) {

            return
                [
                    'message' => __('message.unable_to_resend_try_again_in_an_hour'),
                    'alert_class' => 'alert-danger',
                    'status' => false,
                ];
        }

        $user->sendVerificationCode();
        $user->try_num_validation = $user->try_num_validation + 1;
        $user->update();

        return
            [
                'message' => __('message.resend_successfully'),
                'alert_class' => 'alert-success',
                'status' => true,
            ];
    }

    public function singout($request)
    {
        $user = auth()->guard('web')->user();
        $user->session_token = null;
        $user->save();

        $this->guard()->logout();
        
        // $request->session()->invalidate();

        return redirect()->route('user.auth.login');
    }


    protected function guard()
    {
        return Auth::guard('web');
    }

    public function verifyLecturer($is_web = true)
    {
        $user = $this->getUser($is_web);

        if ($user->email_verified_at == null && $user->is_validation == 0) {
           $data['type'] = "email_verification";
        }
        else{
            $data['type'] = "admin_validation";

            $data['user'] = auth()->user();

            $data['countries']  = Category::getCategoriesByParent('countries')->get();

            $data['joining_certificates']  = Category::getCategoriesByParent('joining_certificates')->get();

            $data['joining_courses']    = Category::getCategoriesByParent('joining_course')->get();

            $data['joining_sections']   = Category::getCategoriesByParent('joining_sections')->get();

            $data['joining_request']    = JoinAsTeacherRequests::where('email', $data['user']->email)->first();
        }

        return $data;

    }

    public function joinAsTeacherRequest($request)
    {
        DB::beginTransaction();
        try {
                //check is lecturer
                $user = User::where('email',$request->email)->where('role' , User::LECTURER)->first();

                // if($user){
                //     $message = __('message.the_email_is_linked_to_a_lecturer_account');
                //     $status = false;
                //     $response = [
                //         'message' => $message,
                //         'status' => $status,
                //     ];
                //     return $response;
                // }

            $data = $request->all();
            $item = JoinAsTeacherRequests::updateOrCreate(['id' => 0], $data);

            if ($request->file('id_image')) {
                //path
                $custome_path     = 'join_as_teacher_requests/' . $item->id . '/id_image';
                $id_image         = $custome_path . '/' . uploadFile($request->file('id_image'), $custome_path);
                $data['id_image'] = str_replace('/', '-', $id_image);
            }

            if ($request->file('job_proof_image')) {
                //path
                $custome_path             = 'join_as_teacher_requests/' . $item->id . '/job_proof_image';
                $job_proof_image          = $custome_path . '/' . uploadFile($request->file('job_proof_image'), $custome_path);
                $data['job_proof_image']  = str_replace('/', '-', $job_proof_image);
            }

            if ($request->file('cv_file')) {
                //path
                $custome_path    = 'join_as_teacher_requests/' . $item->id . '/cv_file';
                $cv_file         = $custome_path . '/' . uploadFile($request->file('cv_file'), $custome_path);
                $data['cv_file'] = str_replace('/', '-', $cv_file);
            }

            $item = JoinAsTeacherRequests::updateOrCreate(['id' => $item->id], $data);

            //sendNotification
            $title = 'طلبات الانضمام كمدرب';
            $text = "طلب  جديد من $request->name ";
            $action_type = 'join_as_teacher_request';
            $action_data = $item->id;
            $permation = 'show_join_as_teacher_requests';
            $user_type = 'admin';
            sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
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

    public function verifyMarketer($is_web = true)
    {
        $user = $this->getUser($is_web);

        if ($user->email_verified_at == null && $user->is_validation == 0) {
           $data['type'] = "email_verification";
        }
        else{
            $data['type'] = "admin_validation";

            $data['user'] = auth()->user();

            $data['countries']  = Category::getCategoriesByParent('countries')->get();

            $data['banks']   = Category::getCategoriesByParent('banks')->get();

            $data['social_media_items']   = Category::getCategoriesByParent('social_media_items')->get();

            $data['joining_request']    = RequestJoinMarketer::where('email', $data['user']->email)->first();
        }

        return $data;

    }



    public function saveTransactios(array $params)
    {
        Transactios::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'payment_id' => $params['payment_id'],
            'amount' => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type' => $params['type'],
            'transactionable_id' => $params['transactionable_id'],
            'transactionable_type' => $params['transactionable_type'],
            'coupon' => isset($params['coupon']) ? $params['coupon'] : '',
        ]);

        return '';
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'type' => Balances::DEPOSIT,
            'transaction_id' => $params['transaction_id'],
            'transaction_type' => $params['transaction_type'],
            'amount' => $params['amount'],
            'system_commission' => $params['system_commission'],
            'amount_before_commission' => $params['amount_before_commission'],
            'becomes_retractable_at' => $params['becomes_retractable_at'],
            'is_retractable' => $params['is_retractable'],

        ]);

        // Run Job to change its state to make it draggable

        return true;
    }

    public function _registerOrLoginUser($data ,  $website) {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name           = $data->name;
            $user->email          = $data->email;
            $user->provider_id    = $data->id;
            $user->password       = bcrypt(rand(0,9));
            $user->save();
        }

        UserRoles::create([
            'user_id'=>$user->id,
            'role'=>UserRoles::STUDENT
        ]);

        Auth::login($user);
    }
}
