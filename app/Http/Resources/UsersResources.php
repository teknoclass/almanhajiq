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
            'image'=> imageUrl($this->image) ,
            'role'=>$this->role ,
            'email'=>$this->email,
            'is_validation' => $this->is_validation,
            'mobile' => $this->mobile,
            'code_country' => $this->code_country,
            'last_login' => $this->last_login_at,
            'join_date' => $this->created_at
        ];
        if ($this->token){
            $data['token'] = $this->token;
        }
        return  $data;
    }
}
