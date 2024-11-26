<?php

namespace App\Repositories\Api;

use Carbon\Carbon;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\UserCourse;
use App\Models\CourseSession;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TeacherHomeCharResource;
use App\Repositories\Front\User\HelperEloquent;
use App\Http\Resources\Lecturer\Home\CharResource;
use App\Http\Resources\Lecturer\Home\LecturerMyProfileResource;
use App\Http\Resources\TeacherIncomingSessionCollection;

class LecturerHomeEloquent extends HelperEloquent{


    function getChart($request,$is_web = true){

        $type = $request->get('type');
        $user = $this->getUser($is_web);


        switch($type){

            case 'day' :
                $start = Carbon::now()->subDay();
                break;
            case 'month' :
                $start = Carbon::now()->subMonth();
                break;
            case 'year' :
                $start = Carbon::now()->subYear();
                break;
            default :
                $start = Carbon::now();

        }
        $data = UserCourse::select('course_id')

                ->whereDate('user_courses.created_at', '>=' , $start)
                ->whereHas('course' , function($query) use($user){
                    $query->where('user_id',$user->id);
                })
                ->groupBy('course_id')
                ->selectRaw('count(*) as subscription_count, course_id')
                ->orderByDesc('subscription_count')
                ->take(10)
                ->with('course')
                ->whereHas('course')
                ->get();

        $data = TeacherHomeCharResource::collection($data);


        return $data;

    }

    function getData($request,$is_web = true){

        $user = $this->getUser($is_web);
        $data['courses_count'] = Courses::where('user_id',$user->id)->where('status','accepted')->count();
        $data['students_count'] = UserCourse::where('lecturer_id',$user->id)->count();

        return $data;


    }

    function getIncomingSession($request,$is_web = true){
        $user = $this->getUser($is_web);
        $currentDateTime = Carbon::now();
        $upcomingSessions = CourseSession::
        whereHas('course',function($query) use ($user){
            $query->where('user_id',$user->id);
        })
        ->where(DB::raw("CONCAT(date, ' ', time)"), '>', $currentDateTime)
        ->with('course')
        ->select('*', DB::raw("ABS(TIMESTAMPDIFF(SECOND, NOW(), STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s'))) as time_difference"))
        ->orderBy('time_difference', 'asc')
        ->paginate(10);

        return new TeacherIncomingSessionCollection($upcomingSessions);


    }



}
