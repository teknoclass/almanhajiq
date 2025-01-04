<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCalendarCourseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['course_id'] = $this->course_id;
        $data['title'] = $this->course->title;
        $data['time'] = $this->time;
        $data['teacher_name'] = $this->course->lecturer->name;

        return $data;
    }
}
