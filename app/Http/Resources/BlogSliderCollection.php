<?php

namespace App\Http\Resources;

class BlogSliderCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'slider_posts');
    }
}



