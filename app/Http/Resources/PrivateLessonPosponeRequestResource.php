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
        if($this->suggested_dates){

            $json = $this->suggested_dates;
            $array = json_decode($json,1);
            $data['date'] = $array['date'];
            $data['from'] = $array['from'];
            $data['to'] = $array['to'];
        }else{
            $data['date'] = null;
            $data['from'] = null;
            $data['to'] = null;
        }
        $data['teacher_name'] = $this->privateLesson->teacher->name;
        $data['teacher_photo'] = imageUrl($this->privateLesson->teacher->image);
        $data['student_name'] = $this->privateLesson->student->name;
        $data['student_photo'] = imageUrl($this->privateLesson->student->image);
        $data['old_date'] = $this->privateLesson->meeting_date;
        $data['old_from'] = $this->privateLesson->time_form;
        $data['old_to'] = $this->privateLesson->time_to;
        $data['teacher_id'] = $this->privateLesson->teacher->id;
        $data['time_type'] = $this->privateLesson->time_type;

        return $data;

    }
}
