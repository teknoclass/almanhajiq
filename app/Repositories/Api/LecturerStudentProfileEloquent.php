<?php

namespace App\Repositories\Api;

use App\Http\Resources\Lecturer\StudentProfile\StudentProfileCommentsResource;
use App\Http\Resources\Lecturer\StudentProfile\StudentProfileCoursesResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\TeacherStudentProfileCommentsCollection;
use App\Http\Resources\TeacherStudentProfileCoursesCollection;
use App\Http\Resources\TeacherStudentProfileCoursesResource;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Courses;
use App\Models\UserCourse;
use App\Http\Resources\UsersResources;
use App\Models\CourseComments;
use App\Repositories\Front\User\HelperEloquent;

class LecturerStudentProfileEloquent extends HelperEloquent{

    function index($id,$is_web = true){

        $user = User::find($id);
        $data['user'] = new UsersResources($user);
        //$data['certificates'] = [imageUrl('image_17257380182005061771.png')];
        return $data;


    }

    function courses($id,$is_web = true){

        $user = $this->getUser($is_web);

        $data = UserCourse::whereHas('course' , function($query) use($user){
            $query->where('user_id',$user->id);
        })->where('user_id',$id)->with(['course' => function($query){
            $query->with('level','priceDetails');
        }])->paginate(10);

        $data = new TeacherStudentProfileCoursesCollection($data);

        return $data;


    }

    function comments($id, $is_web = true){

        $user = $this->getUser($is_web);

        $data = CourseComments::where('user_id',$id)->whereHas('course' , function($query) use ($user){
            $query->where('user_id',$user->id);
        })->with('course','user')->where('parent_id',null)->paginate(10);

        $data = new TeacherStudentProfileCommentsCollection($data);


        return $data;

    }



}
