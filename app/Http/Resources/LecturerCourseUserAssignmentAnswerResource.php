<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerCourseUserAssignmentAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['type'] = $this->type;
        $data['mark'] = $this->userAnswers->mark ?? null;

        if($this->userAnswers != null){
            $data['user_answers'] = [
                'id' => $this->userAnswers->id,
                'answer' => $this->userAnswers->answer
            ];
            if($this->type == 'file'){
                $data['user_answers']['file'] = CourseAssignmentUrl($this->assignment->course_id,$this->userAnswers->file);
            }else{
                $data['user_answers']['file'] = null;
            }
        }else{
            $data['user_answers'] = null;
        }

        return $data;
    }
}
