<?php


namespace App\Http\Resources;

class CourseSessionCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'sessions');
    }
}
