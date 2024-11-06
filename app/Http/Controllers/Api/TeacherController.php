<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Http\Resources\TeacherProfileCollection;
use App\Http\Resources\TeacherProfileResource;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\TeacherService;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{
    public TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function findTeacherById($id)
    {
        $teacher      = $this->teacherService->getById($id);
        $teacherCourses = $this->teacherService->getTeacherCoursesById($id);


        if (!$teacher['status']) {
            $response = new ErrorResponse($teacher['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        if (!$teacherCourses['status']) {
            $response = new ErrorResponse($teacherCourses['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $teachersCollection = new TeacherProfileResource($teacher['data']);

        $teacherCoursesCollection = new ApiCourseFilterCollection($teacherCourses['data']);
        $teacherCoursesCount = count($teacherCourses['data']);
        $response = new SuccessResponse($teacher['message'], [
            [ "title"=>__('teachers'),'teachers' => collect($teachersCollection)],
            ["title"=>__('courses_count'),"courses_count"=>$teacherCoursesCount],
            ["title"=>__('teacher_courses') ,'teacher_courses'=> collect($teacherCoursesCollection)]
        ], Response::HTTP_OK);
        return response()->success($response);
    }
}
