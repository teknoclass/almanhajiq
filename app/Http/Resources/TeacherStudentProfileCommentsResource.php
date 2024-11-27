<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherStudentProfileCommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['user'] = new UsersResources($this->user);
        $data['course_name'] = $this->course->title;
        $data['course_id'] = $this->course->id;
        $data['comment'] = $this->text;

        return $data;
    }
}
