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
        $data['file'] = CourseLiveSessionAttachmenteUrl($this->session->course_id,$this->file);

        return $data;


    }
}
git add