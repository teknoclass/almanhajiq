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
                ['type'=>'video', 'media' => videoUrl($this->video_image)],
                ['type'=>'video','media' => videoUrl($this->video)],
            ],
            'title' => $translation->title ?? $this->title,
            'teacher' => $this->lecturer->name,
            'sessions_count' => count($this->sessions),
            'groups_count' => count($this->groups),
            'can_subscribe_to_session' => $this->can_subscribe_to_session,
            'can_subscribe_to_session_group' => $this->can_subscribe_to_session_group,
            'open_installments' => $this->open_installments,
            'teacher_rating' => $this->lecturer->getRating(),
            'duration' => $this->getDurationInMonths(),
            'description' => $translation->description ?? $this->description,
            'category' => collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name ?? $this->category?->title,
            'price' => $this->priceDetails?->price,
            'discount_price' => $this->priceDetails?->discount_price,
            'rate' => $this->rate,
            'curriculum_items' => $curriculumItems,
            'is_sub' => $this->is_sub,

        ];
        return $data;
    }
}
