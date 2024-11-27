<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherStudentHomeworksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data['id'] = $this->id;
        $data['title'] = isset($this->assignment->translate(app()->getLocale())->title) ? $this->assignment->translate(app()->getLocale())->title : '';
        $data['pass_grade'] = $this->assignment->pass_grade;
        $data['status'] = $this->status;

        $grade = $this->grade;
        $full = $this->assignment->grad;

        $data['grade'] = $this->grade;
        $data['full_grade'] = $this->assignment->grad;

        if($full == 0) $data['percentage'] = 0;
        else {
            $data['percentage'] = ($grade * 100)/$full;
        }

        return $data;
    }
}
