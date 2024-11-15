<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'title' => isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '',
        ];
        if($this->type == 'multiple'){
            $data['asnwers'] = AnswerResource::collection($this->quizzesQuestionsAnswers);
            $data['user_answer'] = $this->userAnswer->answer_id ?? null;
        }else{
            $data['user_answer'] = $this->userAnswer->text_answer ?? null;


        }

        return $data;
    }
}
