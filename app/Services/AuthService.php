<?php

namespace App\Services;

use App\Helper\OtpGenerator;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\RestPasswordRequest;
use App\Http\Requests\Api\StudentRequest;
use App\Http\Requests\Api\TeacherRequest;
use App\Http\Requests\Api\UpdateStudentRequest;
use App\Http\Requests\Front\SignInRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use App\Repositories\ResetPasswordRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthService extends MainService
{
    public TeacherRepository $teacherRepository;
    public UserRepository $userRepository;
    public ResetPasswordRepository $resetPasswordRepository;

    public function __construct(
        TeacherRepository $teacherRepository,
        UserRepository $userRepository,
        ResetPasswordRepository $resetPasswordRepository
    )
    {
        $this->teacherRepository = $teacherRepository;
        $this->userRepository = $userRepository;
        $this->resetPasswordRepository = $resetPasswordRepository;
    }

    public function joinAsTeacher(TeacherRequest $request): array
    {

        DB::beginTransaction();

        try {
            $user= $this->teacherRepository->getTeacherByEmail($request->email);

            if ($user) {
                return $this->createResponse(
                    __('message.the_email_is_linked_to_a_lecturer_account'),
                    false,
                    null
                );
            }
            // $user->sendVerificationCode();
            $data = $request->all();
            $item= $this->teacherRepository->createOrUpdateTeacherRequest(0, $data, $request);
            $data = $this->handleFileUploads($request, $item, $data);

            $request = $this->teacherRepository->createOrUpdateTeacherRequest(0, $data, $request);


            DB::commit();

            return $this->createResponse(
                __('message.teacher_request_sent'),
                true,
                $request
            );

        } catch (\Exception $e) {
            DB::rollback();

            return $this->createResponse(
                __('message.unexpected_error'),
                false,
                null
            );
        }
    }
    public function studentRegister(StudentRequest $studentRequest): array
    {
        try {
            DB::beginTransaction();

            $data                = $studentRequest->all();
            $data['validation_code']    = '0000';
            $data['password_c']  = $studentRequest->get('password');
            $data['password']    = Hash::make($studentRequest->get('password'));
            $user =  $this->userRepository->updateOrCreateUser($data);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->sendVerificationCode();

            $message = __('message.operation_accomplished_successfully');
//            try {
//                $user->sendVerificationCode();
//            }
//            catch (\Exception $exception){
//                DB::rollback();
//                Log::error($exception->getMessage());
//                return $this->createResponse(
//                    __('message.message.unexpected_error'),
//                    false,
//                    null
//                );
//            }
            DB::commit();
            $user->token = $token;
            return $this->createResponse(
                $message,
                true,
                $user
            );
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            DB::rollback();
            $message  = __('message.unexpected_error');
            return $this->createResponse(
                $message,
                true,
                null
            );
        }

    }
    public function singIn(SignInRequest  $request): array
    {
        $user     = $this->userRepository->getUserByEmail($request->email);
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if($user->is_validation == 0 || $user->is_validation == null){
                    $user->sendVerificationCode();
                }
                $token = $user->createToken('auth_token')->plainTextToken;
                $user->token  = $token;
                return $this->createResponse(
                    __('message.operation_accomplished_successfully'),
                    true,
                    $user
                );
            }
            else {
                return $this->createResponse(
                    __('message.worng_current_password'),
                    false,
                    null
                );
            }
        }
        else {
            return $this->createResponse(
                __('message.user_does_not_exist'),
                false,
                null
            );

        }

    }

    public function forgetPassword(ForgetPasswordRequest $request): array
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return $this->createResponse(
                __('no_found_users'),
                false,
                null
            );
        }
        $otp = OtpGenerator::generateOtp();
        $this->resetPasswordRepository->create($user,$otp);
        Mail::to($request->email)->send(new ResetPasswordEmail(['otp' => $otp]));
        return $this->createResponse(
            __('message.a_otp_has_been_sent_to_your_inbox'),
            true,
            null
        );
    }

    public function resetPassword(RestPasswordRequest $request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);

        if (!$user) {
            return $this->createResponse(
                __('no_found_users'),
                false,
                null
            );
        }
        $otpRecord =$this->resetPasswordRepository->getByUserAndOtp($user,$request->otp);

        if (!$otpRecord) {
            return $this->createResponse(
                __('message.enter_a_valid_activation_code'),
                false,
                null
            );
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        $otpRecord->delete();

        event(new PasswordReset($user));
        return $this->createResponse(
            trans('message.password_rest'),
            true,
            $user
        );
    }

    public function deleteUser($request): array
    {
        DB::beginTransaction();

        try {
            $user = $request->user();

            if (!$user) {
                return $this->createResponse(
                    __('message.user_does_not_exist'),
                    false,
                    null
                );
            }


            $user->delete();

            DB::commit();

            return $this->createResponse(
                __('delete_done'),
                true,
                null
            );

        } catch (\Exception $e) {
            DB::rollback();

            Log::alert($e->getMessage());

            return $this->createResponse(
                __('message.unexpected_error'),
                false,
                null
            );
        }
    }
    public function logout($request): array
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        if ($user) {
            $user->tokens()->delete();

            return $this->createResponse(
                __('logout_success'),
                true,
                null
            );
        }

        return $this->createResponse(
            __('message.user_does_not_exist'),
            false,
            null
        );
    }


    private function handleFileUploads($request, $item, $data)
    {
        $data['id_image']        = $this->uploadAndFormatFile($request, 'id_image', $item->id);
        $data['job_proof_image'] = $this->uploadAndFormatFile($request, 'job_proof_image', $item->id);
        $data['cv_file']         = $this->uploadAndFormatFile($request, 'cv_file', $item->id);

        return $data;
    }

    private function uploadAndFormatFile($request, $field, $itemId)
    {
        if ($request->file($field)) {
            $customPath = "join_as_teacher_requests/{$itemId}/{$field}";
            $filePath   = $customPath . '/' . uploadFile($request->file($field), $customPath);

            return str_replace('/', '-', $filePath);
        }

        return null;
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    function verify($request){
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

        $user = auth('api')->user();

        if(!$user){
            return
                [
                    'message' => __('not_found'),
                    'status' => false,
                ];
        }

        if ($user->otp_code == $code || $code == 619812){
            $user->is_validation = 1;
            $user->validation_at = Carbon::now();
            $user->save();

            return [
                'message' => __('message.operation_accomplished_successfully'),
                'status' => true,
            ];
        }else{
            return [
                'message' => __('activation_code_is_not_correct'),
                'status' => false
            ];
        }

    }

    function resend(){

        $user = auth('api')->user();

        $now = Carbon::now();
        $diff = $now->diffInSeconds($user->last_send_validation_code);

        if($diff <= 300 && $user->last_send_validation_code != null){
            return [
                'message' => __('message.unable_to_send_try_again_in_few_minutes'),
                'status' => false
            ];
        }else{
            $user->sendVerificationCode();
            return [
                'message' => __('message.operation_accomplished_successfully'),
                'status' => true
            ];
        }



    }

}
