<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherMyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this['user']->id;
        $data['name'] = $this['user']->name;
        $data['image'] = imageUrl($this['user']->image);
        $data['code_country'] = $this['user']->code_country;
        $data['mobile'] = $this['user']->mobile;
        $data['rating'] = $this['user']->getRating();
        $data['date_of_brith'] = $this['user']->dob;
        $data['mother_lang'] = $this['user']->motherLang->name ?? null;
        $data['ratings'] = TeacherMyProfilRatingseResource::collection($this['ratings']);

        return $data;

    }
}
