<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Services\TeacherService;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Http\Resources\TeacherProfileResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TeacherProfileCollection;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Models\LecturerTimeTable;
use App\Models\PrivateLessons;
use Illuminate\Http\Request;

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
        $todayTimes = $this->getLessonsByDay([
            'date' => date('d-m-Y'),
            'user_id' => $id,
            'type' => 'hour'
        ]);

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
            ["title"=>__('teacher_courses') ,'teacher_courses'=> collect($teacherCoursesCollection)],
            ["title"=>"lessons Times" , 'times' => $todayTimes]
        ], Response::HTTP_OK);
        return response()->success($response);
    }

    function getTimeByDate(Request $request,$id){
        $times = $this->getLessonsByDay([
            'date' => $request->get('date'),
            'user_id' => $id,
            'type' => $request->get('type')
        ]);

        $response = [
            'code' => 200,
            'message' => __('message.success'),
            'data' => $times
        ];
        return response()->json($response);
    }


    function getLessonsByDay($data){

        $dayOrder = Carbon::parse($data['date'])->dayOfWeek;
        $times = LecturerTimeTable::where('user_id',$data['user_id'])->where('day_no',$dayOrder)->get();
        $response = [];

        foreach($times as $time){

            $curTime = Carbon::createFromFormat('H:i', $time['from']);
            $finishTime = Carbon::createFromFormat('H:i', $time['to']);
            if($curTime->minute == 30 && $data['type'] == 'hour'){
                $curTime->addMinutes(30);
            }

            while($curTime->lessThan($finishTime)){
                if($data['type'] == 'hour'){
                    $curTime->addMinutes(60);
                    $editTime = Carbon::parse($curTime)->format('H:i:s');
                    if($curTime->greaterThan($finishTime))break;
                    $curTime->subMinutes(60);
                }else{
                    $curTime->addMinutes(30);
                    $editTime = Carbon::parse($curTime)->format('H:i:s');
                    if($curTime->greaterThan($finishTime))break;
                    $curTime->subMinutes(30);
                }

                $available = PrivateLessons::where('teacher_id',$data['user_id'])->where('meeting_date',$data['date'])
                            ->where(function($query) use ($curTime,$editTime){
                                $query->where('time_form',Carbon::parse($curTime)->format('H:i:s'))
                                ->orWhere('time_to',$editTime);
                            })->first();

                if($available) $yes = 0;
                else $yes = 1;
                $response[] = [
                    'from' => Carbon::parse($curTime)->format('H:i'),
                    'to' => Carbon::parse($editTime)->format('H:i'),
                    'availabe' => $yes
                ];
                if($data['type'] == 'hour'){
                    $editTime = $curTime->addMinutes(60);
                }else{
                    $editTime = $curTime->addMinutes(30);
                }
            }
        }

        return $response;



    }


}
