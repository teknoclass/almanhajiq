<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateLessonPosponeRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['suggested_dates'] = $this->suggested_dates;
        $data['teacher_name'] = $this->privateLesson->teacher->name;
        $data['student_name'] = $this->privateLesson->student->name;

        return $data;

    }
}
