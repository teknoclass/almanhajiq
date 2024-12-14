<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ServiceResource extends JsonResource
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
        // $locale = App::getLocale();
        // $translation = collect($this->translations)
        //         ->firstWhere('locale', $locale)
        //     ?? collect($this->translations)
        //         ->firstWhere('locale', 'en');
        return  [
            'id'          => $this->id,
            'title'       => $this?->title ?? '',
            'image'       => imageUrl($this->image ,'100x100'),
        ];
    }
}
