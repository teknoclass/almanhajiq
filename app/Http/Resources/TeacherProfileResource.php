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
            'description'=>$lecturerSettingTranslation ?$lecturerSettingTranslation->description: $this->lecturerSetting->description,
            'image'=>imageUrl($this->image,'100x100'),
            'experience'=>$this->lecturerSetting?->exp_years,
            'mother_lang'=>$this->motherLang?->name,
            'rating'=>$this->getRating(),
            'teaching_duration'=>null,
            'reviews'=>null,
        ];
    }
}
