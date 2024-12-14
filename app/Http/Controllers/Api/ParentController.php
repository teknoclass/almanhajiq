<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MobileRequest;
use App\Http\Requests\Api\StudentRequest;
use App\Http\Requests\Api\UpdateStudentRequest;
use App\Http\Resources\ParentResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentWithCountsResource;
use App\Http\Resources\StudentWithCoursesResource;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\AuthService;
use App\Services\ParentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends Controller
{
    public ParentService $parentService;
    public AuthService $authService;

    public function __construct(ParentService $parentService,AuthService $authService)
    {
        $this->parentService = $parentService;
        $this->authService   = $authService;
    }

    public function register(StudentRequest $studentRequest)
    {
        $student = $this->authService->parentRegister($studentRequest);
        if (!$student['status']) {
            $response = new ErrorResponse($student['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $parentResource = new ParentResource($student['data']);
        $response        = new SuccessResponse($student['message'],$parentResource, Response::HTTP_OK);

        return response()->success($response);
    }

    public function updateProfile(UpdateStudentRequest $request)
    {
        $user = $this->parentService->editProfile($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }
        $userResource = new ParentResource($user['data']);

        $response     = new SuccessResponse($user['message'],$userResource, Response::HTTP_OK);

        return response()->success($response);
    }

    public function showProfile(Request $request){

        $user = $this->parentService->getProfile($request);

        if (!$user['status']) {
            $response = new ErrorResponse($user['message'], Response::HTTP_NOT_FOUND);

            return response()->error($response);
        }
        $userResource = new ParentResource($user['data']);

        $response     = new SuccessResponse($user['message'],$userResource, Response::HTTP_OK);

        return response()->success($response);
    }

    function verify(Request $request){
        $response = $this->authService->verify($request);
        if($response['status']){
            $response     = new SuccessResponse($response['message'],null, Response::HTTP_OK);
            return response()->success($response);
        }else{
            $response     = new ErrorResponse($response['message'], Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function resend(Request $request){
        $response = $this->authService->resend($request);
        if($response['status']){
            $response     = new SuccessResponse($response['message'],null, Response::HTTP_OK);
            return response()->success($response);
        }else{
            $response     = new ErrorResponse($response['message'], Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }
    }

    function my_sons() {
        $user         = auth('api')->user();
        $sons         = $user->childs;
        $userResource = StudentResource::collection($sons);
        $response     = new SuccessResponse(__('My Sons'),$userResource, Response::HTTP_OK);
        return response()->success($response);
    }

    function show_sons($id) {
        $user         = auth('api')->user();
        $son         =  $user->parentSons->where('son_id' , $id)->first()?->son;
        if(!$son){
            $response = new ErrorResponse(__('not_found'), Response::HTTP_NOT_FOUND);
            return response()->error($response);
        }
        $userResource = new StudentWithCoursesResource($son);
        $response     = new SuccessResponse(__('My Son'),$userResource, Response::HTTP_OK);
        return response()->success($response);
    }

    function store_sons(MobileRequest $request) {
        $student = $this->parentService->store_sons($request);
        if (!$student['status']) {
            $response = new ErrorResponse($student['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $response        = new SuccessResponse($student['message'], null, Response::HTTP_OK);

        return response()->success($response);
    }

    function store_sons_verify(MobileRequest $request) {
        $student = $this->parentService->store_sons_verify($request);
        if (!$student['status']) {
            $response = new ErrorResponse($student['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $response        = new SuccessResponse($student['message'], null, Response::HTTP_OK);

        return response()->success($response);
    }

}
