<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherHomeCharResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->course_id;
        $data['name'] = isset($this->course->translate(app()->getLocale())->title) ? $this->course->translate(app()->getLocale())->title : '';
        $data['subscription_count'] = $this->subscription_count;
        return $data;
    }
}
