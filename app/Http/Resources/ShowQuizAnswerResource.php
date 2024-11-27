<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuizAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'correct' => $this->correct,
            'title' => isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '',

        ];
    }
}
