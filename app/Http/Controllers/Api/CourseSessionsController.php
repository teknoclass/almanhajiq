<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCourseResource;
use App\Http\Resources\CourseSessionCollection;
use App\Http\Resources\CourseSessionGroupCollection;
use App\Http\Resources\CoursesResources;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\CourseService;
use App\Services\LiveSessionService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CourseSessionsController  extends Controller
{
    public LiveSessionService $liveSessionService;
    public CourseService $courseService;

    public function __construct(LiveSessionService $liveSessionService,CourseService $courseService)
    {
        $this->liveSessionService = $liveSessionService;
        $this->courseService = $courseService;
    }

    public function purchaseOptions(Request $request, $id){
        $groups = $this->liveSessionService->getCourseSessionsGroups($id);
        $sessions = $this->liveSessionService->getCourseSessions($id);
        $course = $this->courseService->getCourseByUserId($request,$id);
        if (!$groups['status']) {
            $response = new ErrorResponse($groups['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        if (!$sessions['status']) {
            $response = new ErrorResponse($sessions['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        if (!$course['status']) {
            $response = new ErrorResponse($course['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $CourseResource                 = new ApiCourseResource($course['data']);
        $groupsCollection                = new CourseSessionGroupCollection($groups['data']);
        $sessionsCollection                = new CourseSessionCollection($sessions['data']);
        $courses = new SuccessResponse($groups['message'], [
                $CourseResource,$groupsCollection,$sessionsCollection
            ]
            , Response::HTTP_OK);

        return response()->success($courses);
    }
    public function getCourseSessions(Request $request,$id){


        $collection                 = new CourseSessionCollection($sessions['data']);
        $courses = new SuccessResponse($sessions['message'], $collection
            , Response::HTTP_OK);

        return response()->success($courses);
    }

}
