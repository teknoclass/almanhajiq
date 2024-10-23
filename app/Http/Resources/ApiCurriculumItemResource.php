<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ApiCurriculumItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locale = App::getLocale();

        $translation = collect($this->itemable->translations)
                ->firstWhere('locale', $locale)
            ?? collect($this->translations)
                ->firstWhere('locale', 'en');
        return [
            'id' => $this->itemable_id,
            'course_id' => $this->course_id,
            'item_type' => config("constants.item_model_types.$this->itemable_type"),
            'order' => $this->order,
            config("constants.item_model_types.$this->itemable_type") => [
                'order' => $this->order,
                'teacher' => $this->itemable->creator?->name,
                'time' => $this->itemable->time,
                'grade' => $this->itemable->grade,
                'status' => $this->itemable->status,
                'title' => $translation?->title,
                'description' => $translation?->description,
            ]
        ];
    }
}
