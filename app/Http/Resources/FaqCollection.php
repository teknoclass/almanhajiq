<?php

namespace App\Http\Resources;

class FaqCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, 'faq');
    }
}

