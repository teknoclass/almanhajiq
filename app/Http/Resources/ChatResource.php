<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "id" => $this->id,
            "initiator_id" => $this->initiator_id,
            "partner_id" => $this->partner_id,
            "partner" => Auth::id() === $this->initiator_id ? $this->partner : $this->initiator
        ];
    }
}
