<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['title'] = $this->title;
        $data['text'] = $this->text;
        $data['title_en'] = $this->title_en;
        $data['text_en'] = $this->text_en;
        $data['action_id'] = $this->action_id;
        $data['action_type'] = $this->action_type;
        $data['image'] = imageUrl($this->image);
        $data['read_at'] = $this->read_at;
        return $data;
    }
}
