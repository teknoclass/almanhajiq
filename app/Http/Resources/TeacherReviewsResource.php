<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherReviewsResource extends JsonResource
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

        return [
            'id'=>$this->id,
            'comment_text'=>$this->comment_text,
            'rate'=>$this->rate,
            'user'=>$this->user?->name,
            'image'=>$this->user?->image,

        ];
    }
}
