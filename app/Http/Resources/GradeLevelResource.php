<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class GradeLevelResource extends JsonResource
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
            'id'=>$this->id,
            'level'=> $this->translations?collect($this->translations)->firstWhere('locale', $locale??'en')->name:$this->name??null,
            'sub_levels'=> !$this->getChildren()->get()->isEmpty()?collect(new  SubGradeCollection($this->getChildren()->where('parent_id',$this->id)->get())):null,

        ];
        if ($this->gradeLevels){

            $data['image'] = imageUrl($this->gradeLevels->image,'100x100');
            $data['description'] =$this->gradeLevels->translations?
                collect($this->gradeLevels->translations)
                    ->firstWhere('locale', $locale??'en')?->description:$this->gradeLevels?->description??null;
        }
        return $data;
    }
}
