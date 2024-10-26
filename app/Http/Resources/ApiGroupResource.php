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

        return [
            'id' => $this->id,
            'item_type' => 'group',
            'group' => [
                'id' => $this->id,
                'title' => $this->title,
                'items' => collect(new ApiSessionCollection($this->sessions)),
                'is_sub' => $request->get('user')?(int)$this->canAccess($request->get('user')->id):0,

            ],
        ];
    }
}
