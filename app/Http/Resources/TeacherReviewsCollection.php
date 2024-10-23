<?php

namespace App\Http\Resources;

class TeacherReviewsCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'reviews');
    }
}
