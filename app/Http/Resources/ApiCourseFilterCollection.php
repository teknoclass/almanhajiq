<?php

namespace App\Http\Resources;

class ApiCourseFilterCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'courses');
    }
}

