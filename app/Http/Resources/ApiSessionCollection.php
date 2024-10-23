<?php

namespace App\Http\Resources;

class ApiSessionCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'sessions');
    }
}


