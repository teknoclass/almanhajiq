<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherStudentProfileCoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->course->id;
        $data['title'] = isset($this->course->translate(app()->getLocale())->title) ? $this->course->translate(app()->getLocale())->title : '';
        $data['image'] = imageUrl($this->course->image);
        $data['rate'] = $this->course->getRating();


        if($this->course->level == null){
            $data['level'] = null;
        }else{
            $data['level'] = [
                'id' => $this->course->level->value ?? null,
                'name' => isset($this->course->level->translate(app()->getLocale())->name) ? $this->course->level->translate(app()->getLocale())->name : '',
            ];
        }

        if($this->course->priceDetails == null){
            $data['price_details'] = null;
        }else{
            $data['price_details'] = [
                'price' => $this->course->priceDetails->price ,
                'discount_price' => $this->course->priceDetails->discountPrice
            ];
        }

        return $data;
    }
}
