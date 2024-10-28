<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\RestPasswordRequest;
use App\Http\Requests\Api\TeacherRequest;
use App\Http\Requests\Front\SignInRequest;
use App\Http\Resources\UsersResources;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\AuthService;
use Illuminate\Http\Request;
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

    public function deleteUser(Request $request)
    {
        $user = $this->authService->deleteUser($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }

        $response     = new SuccessResponse($user['message'],null, Response::HTTP_OK);

        return response()->success($response);
    }

    public function logout(Request $request)
    {
        $user = $this->authService->logout($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }

        $response     = new SuccessResponse($user['message'],null, Response::HTTP_OK);

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
