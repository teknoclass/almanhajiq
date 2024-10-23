<?php

namespace App\Repositories;

use App\Models\Courses;

class CourseRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new Courses());
    }

}
