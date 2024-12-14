<?php

namespace App\Http\Resources;

use App\Models\Courses;
use Illuminate\Http\Resources\Json\JsonResource;

// Courses With User Percentage Resources
class CoursesWithUserDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'user_statistics'      => Courses::studentActivity(request()->course_user_id , $this->id ),
        ];
    }
}
