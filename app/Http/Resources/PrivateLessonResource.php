<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['category_id'] = $this->category_id;
        $data['price'] = $this->price;
        $data['is_rated'] = $this->is_rated;
        $data['time_type'] = $this->time_type;
        $data['meeting_date'] = $this->meeting_date;
        $data['time_form'] = $this->time_form;
        $data['time_to'] = $this->time_to;
        $data['meeting_link'] = $this->meeting_link;
        $data['status'] = $this->status;
        $data['created_at'] = $this->created_at;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['description'] = isset($this->translate(app()->getLocale())->description) ? $this->translate(app()->getLocale())->description : '';
        $data['created_at'] = $this->created_at;
        $data['teacher'] = [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
            'image' => imageUrl($this->teacher->image)
        ];
        $data['student'] = [
            'id' => $this->student->id ?? null,
            'name' => $this->student->name ?? null,
            'image' => imageUrl($this->student->image)
        ];
        $data['can_postpone'] = $this->canPostpone();


        return $data;
    }
}
