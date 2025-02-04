<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseSessionAttachemntResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['original_name'] = $this->original_name;
        $data['file'] = fileUrl($this->file);

        return $data;


    }
}
