<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerCourseUserQuizzesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['title'] = isset($this->quiz->translate(app()->getLocale())->title) ? $this->quiz->translate(app()->getLocale())->title : '';
        $data['name'] = $this->user->name;
        $data['pass_grade'] = $this->quiz->pass_mark;
        $data['status'] = $this->status;

        $data['grade'] = $this->user_grade;
        $data['full_grade'] = $this->quiz->grade;

        $grade = $this->grade;
        $full = $this->quiz->grad;
        if($full == 0) $data['percentage'] = 0;
        else {
            $data['percentage'] = ($grade * 100)/$full;
        }
        $data['image'] = imageUrl($this->user->image);

        return $data;
    }
}
