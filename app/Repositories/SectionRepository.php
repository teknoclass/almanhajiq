<?php

namespace App\Repositories;

use App\Models\CourseCurriculum;
use App\Models\CourseSections;

use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class SectionRepository extends BaseRepository
{


    public CourseSections $courseSections;

    public function __construct(CourseSections $courseSections)
    {

        $this->courseSections = $courseSections;
    }

    #[ArrayShape(['type' => "string", 'new_item' => "mixed", 'message' => "mixed|string", 'status' => "bool"])]
    public function addSection($request, $is_web = true): array
    {

        try {
            $user = $this->getUser($is_web);
            if ($request->id) $type = 'edit'; else $type = 'create';
            $data = $request->all();
            if(isset($data['is_active'])) {
                $data['is_active'] = 1;
            }else {
                $data['is_active'] = 0;
            }
            Log::alert($data);
            $item = CourseSections::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            if( $type == 'create') {
                $curriculum_item     = CourseCurriculum::orderBy('id', 'DESC')->select('order')->first();
                if($curriculum_item) {
                    $order = $curriculum_item->order;
                } else {
                    $order = 0;
                }
                $curriculum = CourseCurriculum::create([
                    'course_id'         => $request->course_id,
                    'itemable_id'           => $item->id,
                    'itemable_type'         => CourseSections::class,
                    'order'             =>  $order + 1,
                ]);
                $item->course_curriculum_id = $curriculum->id;
            }

            $item->save();
            $this->notify_registered_users($request->course_id);
            $message = __('message.operation_accomplished_successfully');
            $status = true;
            $response = [
                'type'     => $type,
                'new_item' => $item,
                'message'  => $message,
                'status'   => $status,
            ];

        } catch (\Exception $e) {

            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $e->getMessage(),
                'status' => $status,
            ];
        }

        return $response;
    }

    public function deleteSection($request): array
    {
        try{
            $item = CourseSections::find($request->id);
            if(!$item->can_delete()){
                $message = __('Cannot_Delete_any_of_course_Items_as_Therere_Students_already_subscribed');
                $status = false;
                return [
                    'message' => $message,
                    'status' => $status,
                ];
            }
            CourseCurriculum::where(['itemable_id' => $item->id ])->delete();
            $item->delete();
            $message = __('delete_done');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;
    }
}
