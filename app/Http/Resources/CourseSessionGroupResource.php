<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSessionGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $fullCourseSub = $this->sessions->first()->course->isSubscriber('api');
        if ($fullCourseSub) {
            $isSub = (int)$fullCourseSub;
        }
        else {
            $isSub = $request->get('user') ? (int) $this->canAccess($request->get('user')->id) : 0;
        }
        $data = [
            "id" => $this->id,
            "title" => $this->title,
            "price" => $this->price,
            "sessions_count" => count($this->sessions),
            'is_sub' => $isSub,


        ];

        return $data;
    }
}
