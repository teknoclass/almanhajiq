<?php

namespace App\Http\Resources;

class TeacherProfileCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'Teachers');
    }
}
