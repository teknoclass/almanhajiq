<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiCurriculumAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['time'] = $this->time;
        $data['created_at'] = $this->created_at;
        $data['grade'] = $this->grad;
        $data['pass_mark'] = $this->pass_grade;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['description'] = isset($this->translate(app()->getLocale())->description) ? $this->translate(app()->getLocale())->description : '';
        $data['questions_count'] = $this->assignmentQuestionsCount();
        $data['student_result'] = $this->studentAssignmentResultsApi[0]->status ?? null;
        return $data;
    }
}
