<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class StudentResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $locale = App::getLocale();

        return [
            'id'=>$this->id,
            'email'=>$this->email,
            'name'=>$this->name,
            'role'=>$this->role ,
            'image'=> imageUrl($this->image,'100x100'),
            'mobile'=>$this->mobile,
            'country'=> isset($this->country)?collect($this->country['translations'])->firstWhere('locale', $locale??'en')->name??'':'',
            'token'=> $this->token->token,
        ];
    }
}
