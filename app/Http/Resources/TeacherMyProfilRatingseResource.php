<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherMyProfilRatingseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['rate'] = $this->rate;
        $data['comment'] = $this->comment_text;
        $data['name'] = $this->user->name;
        $data['image'] = imageUrl($this->user->image);

        return $data;

    }
}
