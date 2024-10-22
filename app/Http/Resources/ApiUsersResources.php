<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiUsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id'=>$this->id,
            'name'=>$this->name ,
            'image'=>imageUrl($this->image,'100x100') ,
            'role'=>$this->role ,
            'email'=>$this->email,
            'token'=> $this->token->token,
        ];
    }
}
