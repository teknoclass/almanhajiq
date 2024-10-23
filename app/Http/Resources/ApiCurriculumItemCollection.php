<?php

namespace App\Http\Resources;

class ApiCurriculumItemCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, __('items'));
    }
}

