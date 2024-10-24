<?php

namespace App\Repositories;

use App\Models\CourseSession;

class LiveSessionRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new CourseSession());
    }

    public function getCourseSessionsGroups(){
        return $this->model::groups();
    }
}
