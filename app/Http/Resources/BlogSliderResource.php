<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class BlogSliderResource extends JsonResource
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
            'title'=>$translation?->title??'',
            'text'=>$translation?->text??'',
            'is_favourite'=>$this->is_favourite,
            'image'=> imageUrl($this->image,'100x100'),
            'created_at'=> $this->created_at,
            'category'=> [
                'id'=>$this->category?->id,
                'name'=>collect($this->category?->translations)
                        ->firstWhere('locale', $locale)?->name
                    ?? collect($this->category?->translations)
                        ->firstWhere('locale', 'en')?->name
            ],
            'user'=>[
                'id'=>$this->user?->id,
                'name'=>$this->user?->name,
                'image'=>imageUrl($this->user?->image,'100x100')
            ],
        ];

        return $data;
    }
}
