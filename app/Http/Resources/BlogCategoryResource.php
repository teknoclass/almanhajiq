<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class BlogCategoryResource extends JsonResource
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
        $locale = App::getLocale();
        $translation = collect($this->translations)
                ->firstWhere('locale', $locale)
            ?? collect($this->translations)
                ->firstWhere('locale', 'en');
        $data =  [
            'id'=>$this->id,
            'value'=>$this->value,
            'text'=>$translation?->text??'',
            'image'=> imageUrl($this->image,'100x100'),
            'name'=>$translation?->name??'',
            'description'=>$translation?->description??'',
        ];

        return $data;
    }
}
