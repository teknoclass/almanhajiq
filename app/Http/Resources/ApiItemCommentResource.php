<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiItemCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['comment'] = $this->text;
        $data['user_name'] = $this->user->name;
        $data['user_image'] = imageUrl($this->user->image);
        $data['has_reply'] = $this->hasReply();

        return $data;
    }
}
