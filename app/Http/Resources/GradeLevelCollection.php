<?php

namespace App\Http\Resources;

class GradeLevelCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, __('grade_levels'));
    }
}

