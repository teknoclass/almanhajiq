<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Courses With User Percentage Resources
class CoursesWithPercentageResources extends JsonResource
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
            'id'         => $this->id,
            'title'      => $this->title,
            'percentage' => rand(20,100),
            'user_id'    => request()->course_user_id,
        ];
    }
}
