<?php

namespace App\Http\Resources;

class LatestPostsCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, __('latest_posts'));
    }
}

