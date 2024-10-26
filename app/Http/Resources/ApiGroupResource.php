<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiGroupResource extends JsonResource
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
        $fullCourseSub = $this->sessions->first()->course->isSubscriber('api');
        if ($fullCourseSub) {
            $isSub = (int)$fullCourseSub;
        }
        else {
            $isSub = $request->get('user') ? (int) $this->canAccess($request->get('user')->id) : 0;
        }
        return [
            'id' => $this->id,
            'item_type' => 'group',
            'is_sub' => $isSub,
            'group' => [
                'id' => $this->id,
                'title' => $this->title,
                'items' => collect(new ApiSessionCollection($this->sessions)),

            ],
        ];
    }
}
