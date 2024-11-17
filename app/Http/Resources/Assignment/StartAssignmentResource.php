<?php

namespace App\Http\Resources\Assignment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StartAssignmentResource extends JsonResource
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
        $data['grad'] = $this->grad;
        $data['pass_grade'] = $this->pass_grade;
        $data['active'] = $this->active;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['description'] = isset($this->translate(app()->getLocale())->description) ? $this->translate(app()->getLocale())->description : '';
        $data['assignmentQuestions'] = AssignmentQuestionResource::collection($this->assignmentQuestions);

        return $data;
    }
}
