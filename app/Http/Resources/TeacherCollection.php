<?php

namespace App\Http\Resources;

class TeacherCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'Teachers');
    }
}
