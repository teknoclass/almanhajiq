<?php

namespace App\Http\Resources\Favourite;

use App\Http\Resources\LecturerResource as ResourcesLecturerResource;
use App\Http\Resources\TeacherResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return new TeacherResource($this->lecturer);
    }
}
