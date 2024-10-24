<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $data = [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "time" => $this->time,

        ];
        if ($this->subscription) {
            $data['is_sub']       = 1;
            $data['subscription'] = [
                'id' => $this->subscription?->id,
                'subscription_date' => $this->subscription?->subscription_date,
                'status' => $this->subscription?->status,
                'student_id' => $this->subscription?->student_id,
                'course_session_group_id' => $this->subscription?->course_session_group_id,
                'course_id' => $this->subscription?->course_id,
            ];
        }
        else {
            $data['is_sub'] = 0;

        }
        return $data;
    }
}
