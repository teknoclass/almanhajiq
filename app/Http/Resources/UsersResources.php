<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data =  [
            'id'=>$this->id,
            'name'=>$this->name ,
            'image'=>$this->image ,
            'role'=>$this->role ,
            'email'=>$this->email,

        ];
        if ($this->token){
            $data['token'] = $this->token->token;
        }
        return  $data;
    }
}
