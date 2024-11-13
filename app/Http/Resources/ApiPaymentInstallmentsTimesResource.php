<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPaymentInstallmentsTimesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data['id'] = $this->id;
        $data['title'] = $this->name;
        $data['time'] = $this->courseSession->date;

        return $data;
    }
}
