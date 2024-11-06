<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StudentRequest;
use App\Http\Requests\Api\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\AuthService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public StudentService $studentService;
    public AuthService $authService;

    public function __construct(StudentService $studentService,AuthService $authService)
    {
        $this->studentService = $studentService;
        $this->authService = $authService;
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

    public function updateProfile(UpdateStudentRequest $request)
    {
        $user = $this->studentService->editProfile($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }
        $userResource = new StudentResource($user['data']);

        $response     = new SuccessResponse($user['message'],$userResource, Response::HTTP_OK);

        return response()->success($response);
    }

    public function showProfile(Request $request){

        $user = $this->studentService->getStudentProfile($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }
        $userResource = new StudentResource($user['data']);

        $response     = new SuccessResponse($user['message'],$userResource, Response::HTTP_OK);

        return response()->success($response);
    }

}
