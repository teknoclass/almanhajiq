<?php

namespace App\Http\Resources;

class ApiSingleCourseCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'courses');
    }
}

