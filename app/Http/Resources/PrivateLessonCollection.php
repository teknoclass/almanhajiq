<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resorrces\Json\ResourceCollection;

class PrivateLessonCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource,'lessons');
    }
}
