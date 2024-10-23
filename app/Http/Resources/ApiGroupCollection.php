<?php

namespace App\Http\Resources;

class ApiGroupCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource,'groups');
    }
}

