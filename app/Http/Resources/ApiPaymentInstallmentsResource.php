<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPaymentInstallmentsResource extends JsonResource
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
        $data['items'] = $this->getItems();
        $data['is_paid'] = $this->isPaid();
        $data['is_cur'] = $this->isCur();

        return $data;

    }
}
