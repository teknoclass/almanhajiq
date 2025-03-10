<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
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
            $isSub = auth('api')->user() ? (int) $this->canAccess(auth('api')->id()) : 0;
        }
        $join_url  = '';
        $meetType = '';

        if ($isSub==1 &&  $this->public_password!=null){


            if($this->meeting_status == "finished"){
                $join_url = $this->getRecording();
                $meetType = 'recorded';
            }else{
                $join_url = "";
                $meetType = 'live';
            }

        }
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'item_type' => 'session',
            'is_sub' => $isSub,
            'join_url' => $join_url,
            'meeting_type' => $meetType,
            'is_now' => $this->isNow(),
            'can_postpone' => $this->canPostpone(),
            'attachments' => CourseSessionAttachemntResource::collection($this->attachments),
            'session' => [
                'group_id' => $this->group_id,
                'price' => $this->price,
                'day' => __($this->day),
                'date' => $this->date,
                'time' => $this->time,
                'title' => $this->title,
            ]
        ];
    }
}
