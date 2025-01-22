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

        $fullCourseSub = $this->isSubscriber('api');

        $curriculumItems = new Collection();
        if($this->published){
            $curriculumItems = $curriculumItems->merge(collect(new ApiGroupCollection($this->groups)));
            $curriculumItems = $curriculumItems->merge(collect(new ApiSessionCollection($this->sessions->whereNull('group_id'))));
        }
        $items = collect(new ApiCurriculumItemCollection($this->items_active));
        if($this->valid_on != 'web'){

            if($this->type == 'live'){
                $itemsLive = $items;
                $itemsRec = null;
            }else{
                $itemsLive = null;
                $itemsRec = $items;
            }
        }else{
            $itemsLive = null;
            $itemsRec = null;
        }

        $sessionDays = $this->sessions()->select('day', 'time')->get();
        foreach($sessionDays as $sessionDay){
            $sessionDay->day = __($sessionDay->day);
        }
        /* $formattedDays = implode(',', array_map(
            fn($time, $day) => "{$day} - {$time}",
            array_keys($sessionDays),
            array_values($sessionDays)
        )); */
        $data =  [
            'ttt' => app()->getLocale(),
            'id' => $this->id,
            'slider' => [
               ['type'=>'image','media' => imageUrl($this->image)],
                ['type'=>'image', 'media' =>imageUrl($this->video_image)],
                ['type'=>'video','media' => $this->video],
            ],
            'title' => $translation->title ?? $this->title,

            'sessions_count' => count($this->sessions),
            'groups_count' => count($this->groups),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'subscribe_end_date' => $this->subscription_end_date,
            'can_subscribe' => $this->canSubscribe(),
            'can_subscribe_to_session' => $this->can_subscribe_to_session,
            'can_subscribe_to_session_group' => $this->can_subscribe_to_session_group,
            'open_installments' => $this->open_installments,
            'can_rate' => $this->canRate('api'),
            'valid_on' => $this->valid_on,
            'type' => $this->type,
            'teacher'=>[
                'id' => $this->lecturer->id ?? null,
                'name' => $this->lecturer->name ?? null,
                'teacher_rating' => $this->lecturer ? $this->lecturer->getRating() : null,
                'image' => imageUrl($this->lecturer->image ?? null),

            ],

            'duration' => $this->getDurationInMonths(),
            'max_students' => 10,
            'session_days' =>  [
                'days'=>$sessionDays
            ],
            'description' => $translation->description ?? $this->description,
            'category' => $this->category ? collect($this->category->translations)->firstWhere('locale', $locale ?? 'en')->name ?? $this->category?->title : "",
            'price' => $this->priceDetails?->price??0,
            'discount_price' => $this->priceDetails?->discount_price??0,
            'rate' => $this->rate,
            'curriculum_items' => $curriculumItems,
            'items' => $itemsLive,
            'items_recorded' => $itemsRec,
            'is_bought' => $fullCourseSub,
            'is_start_installment' => $this->isStartInstallment(),
            'is_favourite' => $this->isFavorite('api')
        ];
        return $data;
    }
}
