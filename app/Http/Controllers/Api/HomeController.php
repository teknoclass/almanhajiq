<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Services\HomeService;
use App\Services\CourseService;
use App\Services\TeacherService;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\ApiCourseCollection;
use App\Http\Resources\GradeLevelCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Http\Resources\OpinionCollection;
use App\Http\Resources\OpinionResource;
use App\Services\OpinionService;

class HomeController  extends Controller
{
    public HomeService $homeService;
    public CourseService $courseService;
    public TeacherService $teacherService;
    public BlogService $blogService;
    public OpinionService $opinionService;

    public function __construct(HomeService $homeService , CourseService $courseService , TeacherService $teacherService , BlogService $blogService,
    OpinionService $opinionService)
    {
        $this->homeService = $homeService;
        $this->courseService = $courseService;
        $this->teacherService = $teacherService;
        $this->blogService = $blogService;
        $this->opinionService = $opinionService;
    }

    public function home()
    {
      $topTeachers =  $this->homeService->topTeachers();
      $topCourses =  $this->homeService->mostOrderedCourses();
      $lastCourses = $this->homeService->lastCourses();
      $gradeLevels =  $this->homeService->allGradeLevels();
      $lastPosts = $this->blogService->latestPosts();
      $opinioins = $this->opinionService->lastOpinions();

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
            'last_courses'=>collect(new ApiCourseCollection($lastCourses['data'])),
            'top_teachers'=>collect(new TeacherCollection($topTeachers['data'])),
            'last_posts'=>collect(new PostsCollection($lastPosts['data'])),
            'opinions '=>collect(new OpinionCollection($opinioins))
        ], Response::HTTP_OK);

        return response()->success($response);
    }


    function homeSearch(Request $request){

        if($request->get('filterType') == 'courses'){

            $data = new ApiCourseFilterCollection($this->courseService->courseFilter($request,true)['data']);
        }else{

            $data = new TeacherCollection($this->teacherService->getTeachersByName($request->get('title')));
        }



        $response = new SuccessResponse(__('message.success'),$data,Response::HTTP_OK);

        return response()->success($response);


    }

    public function getOpinion()
    {

      $opinioins = $this->opinionService->allOpinions();

        $response = new SuccessResponse('message.success',
        new OpinionCollection($opinioins)
        , Response::HTTP_OK);

        return response()->success($response);
    }

}
