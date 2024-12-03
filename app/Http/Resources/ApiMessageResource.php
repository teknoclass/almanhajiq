<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['body'] = $this->body;
        $data['sender_id'] = $this->sender_id;
        $data['user_name'] = $this->sender->name;
        $data['user_image'] = imageUrl($this->sender->image);
        $data['created_at'] = $this->created_at;

        return $data;
    }
}
