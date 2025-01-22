<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupons;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Http\Requests\Api\FilterRequest;
use App\Http\Resources\TeacherCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiSingleCourseResource;
use App\Http\Resources\ApiCourseFilterCollection;
use Illuminate\Database\Eloquent\Builder;


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
            $lecturers = $courses['data']->pluck('lecturers')->unique('id')->flatten();

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
        $crs = Courses::find($id);
        $user = auth('api')->user();
        $link = "";
        if($user && $user->role == 'marketer'){
            $user_id = $user->id;
            $url_course = route('courses.single', ['id' => @$crs->id, 'title' => mergeString(@$crs->title, '')]);
            $data['coupon']=Coupons::whereHas('allMarketers', function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->first();
            $code = $data['coupon']->code;
            $link = "$url_course?marketer_coupon=$code";

        }
        $courses = new SuccessResponse($course['message'],  [
            "title"=>__('courses'),'courses' => collect($collection),
            'link' => $link
        ]
        , Response::HTTP_OK);

        return response()->success($courses);
    }

    public function saveComment(Request $request, $course_id)
    {
        $response = $this->courseService->saveComment($request, $course_id,false);

        return $this->response_api($response['status'], $response['message']);
    }


}
