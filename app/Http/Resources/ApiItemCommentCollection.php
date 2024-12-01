<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiItemCommentCollection extends MainCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource,'comments');
    }
}
