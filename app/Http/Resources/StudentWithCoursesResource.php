<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class StudentWithCoursesResource extends JsonResource
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
            "courses"    => CoursesWithUserDetailsResources::collection($this->reserved_courses),
        ];

        return $data;
    }
}
