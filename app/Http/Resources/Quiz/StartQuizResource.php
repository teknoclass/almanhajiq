<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StartQuizResource extends JsonResource
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
        $data['grade'] = $this->grade;
        $data['pass_mark'] = $this->pass_mark;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['description'] = isset($this->translate(app()->getLocale())->description) ? $this->translate(app()->getLocale())->description : '';


        return $data;
    }
}
