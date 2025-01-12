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
use App\Http\Resources\ServiceResource;
use App\Http\Resources\StudentWithCountsResource;
use App\Services\OpinionService;
use App\Services\OurServices;
use Illuminate\Support\Facades\App;

class HomeController  extends Controller
{
    public HomeService $homeService;
    public CourseService $courseService;
    public TeacherService $teacherService;
    public BlogService $blogService;
    public OpinionService $opinionService;
    public OurServices $OurServices;

    public function __construct(HomeService $homeService , CourseService $courseService , TeacherService $teacherService , BlogService $blogService,
    OpinionService $opinionService , OurServices $OurServices)
    {
        $this->homeService = $homeService;
        $this->courseService = $courseService;
        $this->teacherService = $teacherService;
        $this->blogService = $blogService;
        $this->opinionService = $opinionService;
        $this->OurServices = $OurServices;
    }

    public function home()
    {
      $topTeachers = $this->homeService->topTeachers();
      $topCourses  = $this->homeService->mostOrderedCourses();
      $featuredCourses = $this->homeService->featuredCourses();
      $lastCourses = $this->homeService->lastCourses();
      $gradeLevels = $this->homeService->allGradeLevels();
      $lastPosts   = $this->blogService->latestPosts();
      $opinioins   = $this->opinionService->lastOpinions();
      $OurServices = $this->OurServices->lastServices();

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
            'grade_levels' => collect(new GradeLevelCollection($gradeLevels['data'])),
            'top_courses'  => collect(new ApiCourseCollection($topCourses['data'])),
            'featured_courses'  => collect(new ApiCourseCollection($featuredCourses['data'])),
            'last_courses' => collect(new ApiCourseCollection($lastCourses['data'])),
            'top_teachers' => collect(new TeacherCollection($topTeachers['data'])),
            'last_posts'   => collect(new PostsCollection($lastPosts['data'])),
            'opinions'     => collect(new OpinionCollection($opinioins)),
            'our_services' => collect(ServiceResource::collection($OurServices)),
        ], Response::HTTP_OK);

        return response()->success($response);
    }

    public function home_parent()
    {
        $locale = App::getLocale();
        App::setLocale($locale ?? 'ar');

        $user        = auth()->user();
        if(!$user || $user->role != 'parent'){
            $response = new ErrorResponse( __('no_found'), Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

        $sons_count  = $user->parentSons->count();

        $courses     =  $this->homeService->SonsStatistics();

        $response = new SuccessResponse('message.success',[
            'sons_count'   => $sons_count,
            'childs'   =>  StudentWithCountsResource::collection($user->childs),
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

    function calendar(Request $request){
        $data = $this->homeService->calendar($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }


}
