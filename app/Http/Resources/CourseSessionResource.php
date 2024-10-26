<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $data = [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "time" => $this->time,
            'is_sub' => $request->get('user')?(int)$this->canAccess($request->get('user')->id):0,


        ];

        return $data;
    }
}
