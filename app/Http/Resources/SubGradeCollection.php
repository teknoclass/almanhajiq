<?php

namespace App\Http\Resources;

class SubGradeCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'sub_grade_levels');
    }
}

