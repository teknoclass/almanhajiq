<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class StudentWithCountsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        request()->merge(['course_user_id' => $this->id ]);
        $data =  [
            'id'            => $this->id,
            'email'         => $this->email,
            'name'          => $this->name,
            'role'          => $this->role,
            'image'         => imageUrl($this->image,'100x100'),
            'mobile'        => $this->mobile,
            'is_validation' => $this->is_validation ?? 0,
            'counts'=>[
                "courses"                  => $this->courses->count(),
                "courses_acheived"         => $this->courses->count(),
                "live_lessons"             => $this->liveCourseCount(),
                "live_lessons_acheived"    => $this->liveCourseCount(),
                "private_lessons_count"    => $this->privateLessonsCount(),
                "private_lessons_acheived" => $this->privateLessonsCount(),
            ],
            "courses"    => CoursesWithPercentageResources::collection($this->reserved_courses),
        ];

        return $data;
    }
}
