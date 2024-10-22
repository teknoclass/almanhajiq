<?php

namespace App\Http\Resources;

class CategoryCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, $resource->first()->parent);
    }
}

