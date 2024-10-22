<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCourseCollection;
use App\Http\Resources\GradeLevelCollection;
use App\Http\Resources\TeacherCollection;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\HomeService;
use Symfony\Component\HttpFoundation\Response;

class HomeController  extends Controller
{
    public HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function home()
    {
      $topTeachers =  $this->homeService->topTeachers();
      $topCourses =  $this->homeService->mostOrderedCourses();
      $gradeLevels =  $this->homeService->allGradeLevels();

        if (!$topCourses['status']) {
            $response = new ErrorResponse($topCourses['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        if (!$topTeachers['status']) {
            $response = new ErrorResponse($topTeachers['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        if (!$gradeLevels['status']) {
            $response = new ErrorResponse($gradeLevels['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }


        $response = new SuccessResponse('message.success',[
            'grade_levels'=>collect(new GradeLevelCollection($gradeLevels['data'])),
            'top_courses'=>collect(new ApiCourseCollection($topCourses['data'])),
            'top_teachers'=>collect(new TeacherCollection($topTeachers['data']))
        ], Response::HTTP_OK);

        return response()->success($response);
    }
}
