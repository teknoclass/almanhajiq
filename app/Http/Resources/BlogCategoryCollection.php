<?php

namespace App\Http\Resources;

class BlogCategoryCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'categories');
    }
}


