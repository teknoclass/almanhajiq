<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ApiSingleCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locale      = App::getLocale();
        $translation = collect($this->translations)
                ->firstWhere('locale', $locale)
            ?? collect($this->translations)
                ->firstWhere('locale', 'en');


        $curriculumItems = new Collection();
        $curriculumItems = $curriculumItems->merge(collect(new ApiGroupCollection($this->groups)));
        $curriculumItems = $curriculumItems->merge(collect(new ApiSessionCollection($this->sessions->whereNull('group_id'))));
        $curriculumItems = $curriculumItems->merge(collect(new ApiCurriculumItemCollection($this->items)));

        $data =  [
            'id' => $this->id,
            'slider' => [
               ['type'=>'image','media' => imageUrl($this->image,'100x100')],
                ['type'=>'image', 'media' =>imageUrl($this->video_image,'100x100')],
                ['type'=>'video','media' => $this->video],
            ],
            'title' => $translation->title ?? $this->title,

            'sessions_count' => count($this->sessions),
            'groups_count' => count($this->groups),
            'start_date' => $this->start_date,
            'can_subscribe_to_session' => $this->can_subscribe_to_session,
            'can_subscribe_to_session_group' => $this->can_subscribe_to_session_group,
            'open_installments' => $this->open_installments,
            'teacher'=>[
                'id' => $this->lecturer->id,
                'name' => $this->lecturer->name,
                'teacher_rating' => $this->lecturer->getRating(),
                'image' => imageUrl($this->lecturer->image,'100x100'),

            ],

            'duration' => $this->getDurationInMonths(),
            'max_students' => 10,
            'session_days' =>  $this->sessions->pluck('time','day'),
            'description' => $translation->description ?? $this->description,
            'category' => collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name ?? $this->category?->title,
            'price' => $this->priceDetails?->price??0,
            'discount_price' => $this->priceDetails?->discount_price??0,
            'rate' => $this->rate,
            'curriculum_items' => $curriculumItems,

        ];
        return $data;
    }
}
