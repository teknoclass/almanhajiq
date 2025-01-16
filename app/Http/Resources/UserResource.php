<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'id'=>$this->id,
            'name'=>$this->name ,
            'image'=> imageUrl($this->image) ,
            'role'=>$this->role ,
            'email'=>$this->email,
            'is_validation' => $this->is_validation,
            'mobile' => $this->mobile,
            'code_country' => $this->code_country

        ];
        if ($this->token){
            $data['token'] = $this->token;
        }
        return  $data;

    }
}
