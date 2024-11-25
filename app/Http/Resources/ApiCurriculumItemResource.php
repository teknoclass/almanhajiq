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
        $fullCourseSub = $this->course->isSubscriber('api');
        if ($fullCourseSub) {
            $isSub = (int)$fullCourseSub;
        }else {
            $isSub = $this->isSubInInstallment('api');
        }

        $translation = collect($this->itemable->translations)
                ->firstWhere('locale', $locale)
            ?? collect($this->translations)
                ->firstWhere('locale', 'en');

        return [
            'id' => $this->itemable_id,
            'course_id' => $this->course_id,
            'is_sub' => $isSub??0,
            'item_type' => config("constants.item_model_types.$this->itemable_type"),
            'order' => $this->order,
            'start_date' => $this->itemable->start_date,
            'end_date' => $this->itemable->end_date,
            'is_completed' => $this->is_completed(),
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
