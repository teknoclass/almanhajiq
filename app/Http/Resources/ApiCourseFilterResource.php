<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ApiCourseFilterResource extends JsonResource
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

        if($this->category != null){
            $category = collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name??$this->categoy?->title;
        }else{
            $category = "";
        }

        return [
            'id' => $this->id,
            'image' => imageUrl($this->image,'100x100'),
            'title' => $translation->title??$this->title,
            'teacher' => $this->lecturer->name ?? "",
            'description' => $translation->description??$this->description,
            'category' => $category,
            'price' => $this->priceDetails?->price,
            'discount_price' => $this->priceDetails?->discount_price,
            'rate'=>$this->rate,
            'is_favourite' => $this->isFavorite('api')

        ];
    }
}
