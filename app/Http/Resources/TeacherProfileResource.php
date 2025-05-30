<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherProfileResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {

        $lecturerSettingTranslation = collect($this->lecturerSetting?->translations)->firstWhere('locale', $locale ?? 'ar');
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$lecturerSettingTranslation ?$lecturerSettingTranslation->description: @$this->lecturerSetting->description,
            'position'=>$lecturerSettingTranslation ?$lecturerSettingTranslation->position: @$this->lecturerSetting->position,
            'image'=>imageUrl($this->image),
            'experience'=>@$this->lecturerSetting?->exp_years,
            'mother_lang'=>@$this->motherLang?->name,
            'rating'=>$this->getRating(),
            'teaching_duration'=>null,
            'can_add_half_hour' => $this->can_add_half_hour,
            'reviews'=>$this->reviews?collect(new TeacherReviewsCollection($this->reviews)):null,
            'times' => $this->timeTable?collect(new TeacherTimeTableCollection($this->timeTable)):null,
            'hour_price' => $this->hour_price,
            'half_hour_price' => $this->half_hour_price
        ];
    }
}

