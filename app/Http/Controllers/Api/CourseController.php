<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterRequest;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Http\Resources\ApiSingleCourseResource;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherProfileCollection;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\CourseService;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    public CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function courseFilter(FilterRequest $filterRequest)
    {

        $courses          = $this->courseService->courseFilter($filterRequest);
        $mostOrderCourses = $this->courseService->mostOrderCourses($filterRequest);

        if (!$courses['status']) {
            $response = new ErrorResponse($courses['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $mostOrderCoursesCollection = new ApiCourseFilterCollection($mostOrderCourses['data']);
        if ($filterRequest->has('material_id') && $courses['data']->isNotEmpty()) {
            $lecturers = $courses['data']->pluck('lecturers')->flatten();

            $collection = new TeacherCollection($lecturers);
            $courses = new SuccessResponse($courses['message'], [
                [ "title"=>__('teachers'),'teachers' => collect($collection)],
                ["title"=>__('most_order_courses') ,'most_order_courses'=> collect($mostOrderCoursesCollection)]
            ], Response::HTTP_OK);
            return response()->success($courses);

        }

        $collection                 = new ApiCourseFilterCollection($courses['data']);
        $courses = new SuccessResponse($courses['message'], [
           [ "title"=>__('courses'),'courses' => collect($collection)],
            ["title"=>__('most_order_courses') ,'most_order_courses'=> collect($mostOrderCoursesCollection)]
        ], Response::HTTP_OK);

        return response()->success($courses);
    }

    public function getCourse($id){
        $course  =  $this->courseService->getById($id);
        if (!$course['status']) {
            $response = new ErrorResponse($course['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $collection                 = new ApiSingleCourseResource($course['data']);
        $courses = new SuccessResponse($course['message'],  [ "title"=>__('courses'),'courses' => collect($collection)]
        , Response::HTTP_OK);

        return response()->success($courses);
    }

}
