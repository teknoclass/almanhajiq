<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherStudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->user->id;
        $data['name'] = $this->user->name;
        $data['image'] = imageUrl($this->user->image);
        $data['course_count'] = $this->user->courseCountForSpecificTeacher('api');
        //$data['certificate_count'] = $this->user->certificateCountForSpecificTeacher('api');

        return $data;
    }
}
