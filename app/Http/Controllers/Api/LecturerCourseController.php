<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use App\Services\CourseSessionService;
use App\Http\Resources\ApiCourseResource;
use App\Http\Requests\ApiSubmitMarkRequest;
use App\Http\Resources\ApiCourseCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Repositories\Front\User\Lecturer\CoursesEloquent;

class LecturerCourseController extends Controller
{

    private $courses;
    private $courseSessionService;
    function __construct(CoursesEloquent $courses_eloquent,CourseSessionService $courseSessionService)
    {
        $this->courses = $courses_eloquent;
        $this->courseSessionService = $courseSessionService;
    }


    function courseStudent(Request $request){

        $data = $this->courses->courseStudent($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function myCourses(Request $request){

        $data = $this->courses->myCourses($request,false);

        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),[
            new ApiCourseCollection($data['courses'])
        ],
        Response::HTTP_OK);

        return response()->success($response);


    }

    function courseUserAssignments(Request $request){
        $data = $this->courses->courseUserAssignments($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function courseAssignment($course_id){
        $data = $this->courses->courseAssignment($course_id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function courseUserQuizzes(Request $request){
        $data = $this->courses->courseUserQuizzes($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function courseQuiz($course_id){
        $data = $this->courses->courseQuiz($course_id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function previewUserQuiz($id){
        $data = $this->courses->previewUserQuiz($id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function getStudentAnswer($result_id){
        $data = $this->courses->getStudentAnswer($result_id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function submitMark(ApiSubmitMarkRequest $request){
        $data = $this->courses->submitMark($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function submitResult(Request $request){
        $data = $this->courses->submitResult($request,false);

        return $this->response_api($data['status'],$data['message']);
    }

    public function createLiveSession($id){
        $url = $this->courses->createLiveSession($id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$url);

    }

    public function storePostponeRequest(Request  $request)
    {

        $request->validate([
            'course_session_id' => 'required|exists:course_sessions,id',
            'suggested_dates' => 'required|array|min:1',
            'suggested_dates.*' => 'date',
            'optional_files' => 'nullable|file',
        ]);

        $response = $this->courseSessionService->storePostponeRequest($request,false);
        return response()->json($response);
    }

    public function getMyCategories(Request $request){
        $data = $this->courses->getMyCategories($request,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

    function getStudentHomeworks($course_id,$student_id){
        $data = $this->courses->getStudentHomeworks($course_id,$student_id,false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function showQuiz($quiz_id){

        $data = $this->courses->showQuiz($quiz_id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

    function showAssignment($assignment_id){

        $data = $this->courses->showAssignment($assignment_id);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }



}
