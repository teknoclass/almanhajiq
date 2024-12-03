<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $user = $this->otherUser('api');
        $data['initiator_id'] = $this->initiator_id;
        $data['partner_id'] = $user->id;
        $data['latest_message_created_at'] = $this->latest_message_created_at;
        $data['last_message'] = $this->lastMessage()->body ?? null;
        $data['numberOfUnReadMessages'] = $this->unReadMessages('api');
        $data['name'] = $user->name;
        $data['image'] = imageUrl($user->image);


        return $data;
    }
}
