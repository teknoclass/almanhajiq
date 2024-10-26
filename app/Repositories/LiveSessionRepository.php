<?php

namespace App\Repositories;

use App\Models\Courses;
use App\Models\CourseSession;
use App\Models\CourseSessionSubscription;
use App\Models\User;

class LiveSessionRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new CourseSession());
    }

    public function getCourseSessionsGroups($id)
    {
        return Courses::where('id', $id)
                         ->with('groups')
                         ->get()
                         ->pluck('groups')
                         ->first()
                         ->unique('id');


    }


    public function getCourseSessions($id){

        return Courses::where('id',$id)->with('sessions')->get()->pluck('sessions')->first()->unique('id');

    }


}
