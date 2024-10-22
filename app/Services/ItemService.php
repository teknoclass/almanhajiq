<?php
namespace App\Services;

use App\Models\CourseCurriculum;
use App\Models\CourseSectionItems;
use Illuminate\Support\Facades\Log;

class ItemService
{

    public static function storeSectionItem($data, $item,$type): void
    {
        if(isset($data['course_sections_id'])) {

            $section_item2     = CourseSectionItems::orderBy('id', 'DESC')->select('order')->first();
            if($section_item2) {
                $order = $section_item2->order;
            } else {
                $order = 0;
            }
           CourseSectionItems::create([
                'course_id'             => $data['course_id'],
                'course_sections_id'    => $data['course_sections_id'],
                'itemable_id'               => $item->id,
                'itemable_type'             => $type,
                'order'                 =>  $order + 1,
            ]);
        }else {
            $curriculum_item     = CourseCurriculum::orderBy('id', 'DESC')->select('order')->first();
            if($curriculum_item) {
                $order = $curriculum_item->order;
            } else {
                $order = 0;
            }
           CourseCurriculum::create([
                'course_id'         => $data['course_id'],
                'itemable_id'           => $item->id,
                'itemable_type'         => $type,
                'order'             =>  $order + 1,
            ]);
        }
    }
}
