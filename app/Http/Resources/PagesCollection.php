<?php

namespace App\Http\Resources;

class PagesCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, __('materials'));
    }
}

