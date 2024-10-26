<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

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
        $join_url  = '';
        if ($isSub==1 &&  $this->password!=null){
            $join_url = URL::temporarySignedRoute(
                'user.courses.live.joinLiveSession',
                now()->addMinutes(5),
                [
                    'id' => $this->id,
                    'userName' => $request->user()->name,
                    'password' => $this->public_password
                ]
            );
        }
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'item_type' => 'session',
            'is_sub' => $isSub,
            'join_url' => $join_url,

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
