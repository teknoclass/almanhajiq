<?php


namespace App\Http\Resources;

class CourseSessionGroupCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'groups');
    }
}
