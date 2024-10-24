<?php

namespace App\Http\Resources;

class PostsCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource,'posts');
    }
}

