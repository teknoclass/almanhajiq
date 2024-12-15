<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LessonIdRequest;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use App\Repositories\Front\User\CoursesEloquent;
use App\Repositories\Common\CourseCurriculumEloquent;
use App\Repositories\Front\User\RatingsEloquent;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{
    private $courses;
    private $course_curriculum;
    private $ratings;

    public function __construct(CoursesEloquent $courses_eloquent, CourseCurriculumEloquent $course_curriculum_eloquent,
    RatingsEloquent $ratings_eloquent)
    {
        $this->courses = $courses_eloquent;
        $this->course_curriculum = $course_curriculum_eloquent;
        $this->ratings = $ratings_eloquent;
    }


    function getItemApi(Request $request , $id){
        $type = $request->get('type');
        $data = $this->course_curriculum->getItemApi($id,$type);
        return $data;
        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),$data,Response::HTTP_OK);

        return response()->success($response);
    }


    function endLesson(LessonIdRequest $request)
    {
        $data = $this->courses->endLessons($request,false);
        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message,$data);
    }

    function getComments(Request $request)
    {
        $data = $this->courses->getComments($request['item_id'],$request['item_type'],false);
        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message,$data);
    }

    function getReplys($comment_id){
        $data = $this->courses->getReplys($comment_id,false);
        $message = __('message.operation_accomplished_successfully');
        return $this->response_api(true,$message,$data);

    }

    public function addRate(Request $request)
    {

        $response = $this->ratings->add($request,false);

        return $this->response_api($response['status'], $response['message']);
    }
    public function getRate(Request $request)
    {

        $response = $this->ratings->get($request,false);

        return $this->response_api(true,__('message.operation_accomplished_successfully'),$response);
    }

}
