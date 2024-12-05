<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpinionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['image'] = imageUrl($this->image);
        $data['name'] = isset($this->translate(app()->getLocale())->name) ? $this->translate(app()->getLocale())->name : '';
        $data['text'] = isset($this->translate(app()->getLocale())->text) ? $this->translate(app()->getLocale())->text : '';
        $data['rate'] = $this->rate;


        return $data;

    }
}
