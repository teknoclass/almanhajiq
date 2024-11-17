<?php

namespace App\Http\Resources\Assignment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['type'] = $this->type;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        if($this->type == 'text'){
            $data['userAnswer'] = $this->userAnswers->answer ?? null;
        }else{
            $data['types'] = [
                'image',
                'video',
                'pdf',
                'word'
            ];
            if($this->userAnswers != null){

                if($this->userAnswers->file != null){
                    $data['userAnswer'] = CourseAssignmentUrl($this->assignment->course_id,$this->userAnswers->file);
                }
            }
        }

        return $data;
    }
}
