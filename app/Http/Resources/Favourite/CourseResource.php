<?php

namespace App\Http\Resources\Favourite;

use App\Http\Resources\ApiCourseFilterResource;
use App\Http\Resources\Courses\CoursesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return new ApiCourseFilterResource($this->course);
    }
}
