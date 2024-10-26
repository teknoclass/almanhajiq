<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ApiCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $gradeSubLevel = Category::where('id',$this->grade_sub_level)->with('translations')->first();
        $locale = App::getLocale();

        $data =  [
            'id'=>$this->id,
            'image'=>imageUrl($this->image,'100x100'),
            'title'=>collect($this->translations)->firstWhere('locale', $locale??'en')->title ,
            'description'=>collect($this->translations)->firstWhere('locale', $locale??'en')->description ,
            'grade_sub_level'=>collect($gradeSubLevel->translations)->firstWhere('locale', $locale??'en')->name,
            'category' => collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name??$this->categoy?->title,
            'lecturer'=>$this->lecturer->name,
            'price'=>$this->priceDetails?->price,
            'rate'=>$this->rate,
            'discount_price'=>$this->priceDetails?->discount_price,
            'is_sub'=>0
        ];
        if ($this->is_sub){
            $data['is_sub']=1;
        }
        return $data;
    }
}
