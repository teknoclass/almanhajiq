<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\RestPasswordRequest;
use App\Http\Requests\Api\StudentRequest;
use App\Http\Requests\Api\TeacherRequest;
use App\Http\Requests\Front\SignInRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UsersResources;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Mail\ResetPasswordEmail;
use App\Models\ResetPasswordOtp;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registerTeacher(TeacherRequest $teacherRequest)
    {
        $teacher = $this->authService->joinAsTeacher($teacherRequest);

        if (!$teacher['status']) {
            $response = new ErrorResponse($teacher['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $response = new SuccessResponse($teacher['message'],null, Response::HTTP_OK);

        return response()->success($response);
    }

    public function registerStudent(StudentRequest $studentRequest)
    {
        $student = $this->authService->studentRegister($studentRequest);

        if (!$student['status']) {
            $response = new ErrorResponse($student['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $studentResource = new StudentResource($student['data']);
        $response        = new SuccessResponse($student['message'],$studentResource, Response::HTTP_OK);

        return response()->success($response);
    }

    public function login(SignInRequest $signInRequest)
    {
        $user = $this->authService->singIn($signInRequest);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $userResource = new UsersResources($user['data']);
        $response     = new SuccessResponse($user['message'],$userResource, Response::HTTP_OK);

        return response()->success($response);
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $data = $this->authService->forgetPassword($request);
        if (!$data['status']) {
            $response = new ErrorResponse($data['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $response = new SuccessResponse($data['message'],null, Response::HTTP_OK);
        return response()->success($response);
    }

    public function resetPassword(RestPasswordRequest $request)
    {
        $data = $this->authService->resetPassword($request);
        $response = new SuccessResponse($data['message'],null, Response::HTTP_OK);
        return response()->success($response);
    }
}
