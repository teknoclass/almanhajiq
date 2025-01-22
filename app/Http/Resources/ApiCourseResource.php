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
            'image'=>imageUrl($this->image),
            'title'=>collect($this->translations)->firstWhere('locale', $locale??'en')->title ,
            'description'=>collect($this->translations)->firstWhere('locale', $locale??'en')->description ,
            'grade_sub_level'=>$gradeSubLevel ? collect($gradeSubLevel->translations)->firstWhere('locale', $locale??'en')->name : "",
            'category' => $this->material ? collect($this->material->translations)->firstWhere('locale', $locale ?? 'en')->name??$this->material?->title : "",
            'category_id' => $this->material_id,
            'lecturer'=>$this->lecturer->name ?? null,
            'price'=>$this->priceDetails?->price ?? null,
            'rate'=>$this->rate,
            'discount_price'=>$this->priceDetails?->discount_price,
            'is_sub'=>0,
            'is_favourite' => $this->isFavorite('api'),
            'type' => $this->type,
            'status' => $this->status,
            'student_count' => $this->studentsCount()
        ];
        if ($this->is_sub){
            $data['is_sub']=1;
        }
        return $data;
    }
}
