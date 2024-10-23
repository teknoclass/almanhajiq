<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiSessionResource extends JsonResource
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
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'item_type' => 'session',
            'session'=>[
                'group_id' => $this->group_id,
                'price' => $this->price,
                'day' => $this->day,
                'date' => $this->date,
                'time' => $this->time,
                'title' => $this->title,
            ]
        ];
    }
}
