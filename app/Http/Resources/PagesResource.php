<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PagesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
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
        $data = [
            'id' => $this->id,
            'image' => imageUrl($this->image),
            'title' => $translation?->title??'',
            'text' => $translation?->text??'',

        ];

        return $data;
    }
}
