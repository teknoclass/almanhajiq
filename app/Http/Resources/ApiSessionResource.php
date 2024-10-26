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
        $fullCourseSub = $this->course->isSubscriber('api');
        if ($fullCourseSub) {
            $isSub = (int)$fullCourseSub;
        }
        else {
            $isSub = $request->get('user') ? (int) $this->canAccess($request->get('user')->id) : 0;
        }

        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'item_type' => 'session',
            'is_sub' => $isSub,
            'session' => [
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
