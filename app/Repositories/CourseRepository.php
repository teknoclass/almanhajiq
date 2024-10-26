<?php

namespace App\Repositories;

use App\Models\Courses;
use App\Models\UserCourse;

class CourseRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new Courses());
    }

    public function getCourseByUserId($user, $id)
    {
        if ($user) {
            return UserCourse::where('course_id', $id)->where('user_id', $user->id)->first();
        }

        return null;
    }
}
