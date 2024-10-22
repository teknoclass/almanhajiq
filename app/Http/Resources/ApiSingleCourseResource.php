<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ApiSingleCourseResource extends JsonResource
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

        $locale      = App::getLocale();
        $translation = collect($this->translations)
                ->firstWhere('locale', $locale)
            ?? collect($this->translations)
                ->firstWhere('locale', 'en');

        return [
            'id' => $this->id,
            'image' => imageUrl($this->image,'100x100'),
            'video_image' => videoUrl($this->video_image),
            'video' => videoUrl($this->video),
            'title' => $translation->title??$this->title,
            'teacher' => $this->lecturer->name,
            'can_subscribe_to_session' => $this->can_subscribe_to_session,
            'can_subscribe_to_session_group' => $this->can_subscribe_to_session_group,
            'open_installments' => $this->open_installments,
            'teacher_rating' => $this->lecturer->getRating(),
            'duration' => $this->getDurationInMonths(),
            'description' => $translation->description??$this->description,
            'category' => collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name??$this->categoy?->title,
            'price' => $this->priceDetails?->price,
            'discount_price' => $this->priceDetails?->discount_price,
            'rate'=>$this->rate,
            'sessions'=>$this->sessions??''

        ];
    }
}
