<?php

namespace App\Http\Resources;

class ApiCourseCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'courses');
    }
}

