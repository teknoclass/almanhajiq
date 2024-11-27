<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuizResource extends JsonResource
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
            $data['asnwers'] = ShowQuizAnswerResource::collection($this->quizzesQuestionsAnswers);

        }

        return $data;
    }
}
