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
    publicu fnction toArray($request)
    {
        $fullCourseSub = $this->course->isSubscriber('api');
        if ($fullCourseSub) {
            $isSub = (int)$fullCourseSub;
        }
        else {
            $isSub = auth('api')->user() ? (int) $this->canAccess(auth('api')->id()) : 0;
        }
        $data = [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "time" => $this->time,
            'date' => $this->date,
            'is_sub' => $isSub
        ];
        return $data;
    }
}
