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

        $data =  [
            'id' => $this->id,
            'email'=>$this->email,
            'name'=>$this->name,
            'role'=>$this->role ,
            'image'=> imageUrl($this->image),
            'mobile'=>$this->mobile,
            'is_validation' => $this->is_validation ?? 0,
            'country_code'=>$this->code_country,
            'info'=>[
                'courses_count'=>count($this->courses),
                // 'private_lessons_count'=>count($this->privateLessons),
            ]+$this->user_activities(),
            'country'=> isset($this->country)?collect($this->country['translations'])->firstWhere('locale', $locale??'en')->name??'':'',
        ];
        if ($this->token)
        {
            $data['token']=$this->token;
        }
        return $data;
    }
}
