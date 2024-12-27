<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherTimeTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data['id'] = $this->id;
        $data['day_number'] = $this->day_no;
        $data['from'] = $this->from;
        $data['to'] = $this->to;


        return $data;

    }
}
