<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherIncomingSessionResource extends JsonResource
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
        $data['title'] = $this->title;
        $data['date'] = $this->date;
        $data['time'] = $this->time;
        $data['course_name'] = $this->course->title ?? "";
        $data['course_image'] =  imageUrl($this->course->image,'100x100');
        $data['remaining_time_in_second'] = $this->time_difference;

        return $data;

    }
}
