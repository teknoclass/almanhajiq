<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCalendarPrivateLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['teacher_name'] = $this->teacher->name;
        $data['from'] = $this->time_form;
        $data['to'] = $this->time_to;

        return $data;
    }
}
