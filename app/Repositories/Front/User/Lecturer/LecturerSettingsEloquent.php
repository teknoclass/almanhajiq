<?php

namespace App\Repositories\Front\User\Lecturer;

use App\Models\Category;
use App\Models\Courses;
use App\Models\LecturerExpertise;
use App\Models\LecturerSetting;
use App\Models\LecturerTimeTable;
use App\Models\User;
use App\Models\UserCategory;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\DB;

class LecturerSettingsEloquent extends HelperEloquent
{

    public function index($active_tab, $is_web = true) {


        $data['active_tab'] = $active_tab;

        if ($active_tab == 'main') {

            $data['lecturer'] = User::where('id', auth()->id())->
                select( 'id', 'name', 'image', 'gender', 'country_id', 'mother_lang_id',
                    'city', 'dob', 'mobile', 'email', 'code_country', 'slug_country'
                )->first();

            $data['countries']  = Category::getCategoriesByParent('countries')->get();

            $data['languages']  = Category::getCategoriesByParent('course_languages')->get();

        }
        else if($active_tab == 'education') {

            $data['lecturer'] = User::where('id', auth()->id())
                // ->select( 'id')
                ->with('materials','languages')
                ->with([
                    'lecturerSetting' => function ($query) {
                        $query->select('id', 'user_id', 'video_thumbnail', 'video_type', 'video', 'exp_years', 'major_id')
                            ->with('translations:lecturer_setting_id,abstract,description,position,locale');
                    }
                ])->first();

            $data['majors']  = Category::query()->select('id', 'value', 'parent')
                ->with('translations:category_id,name,locale')
                ->where('parent', 'joining_sections')
                ->orderByDesc('created_at')->get();

            $data['expertise'] = LecturerExpertise::where('user_id', auth()->id())
                ->select( 'id', 'user_id', 'start_date', 'end_date')
                ->with('translations:lecturer_expertise_id,name,description,locale')
                ->get();

            $data['materials']  = Category::getCategoriesByParent('joining_course')->get();

            $data['languages']  = Category::getCategoriesByParent('course_languages')->get();

            $data['lecturer_materials'] = $data['lecturer']->materials;

            $data['lecturer_languages'] = $data['lecturer']->languages;

        }
        else if($active_tab == 'contacts') {

            $data['lecturer'] = User::where('id', auth()->id())
                ->select( 'id')
                ->with([
                    'lecturerSetting' => function ($query) {
                        $query->select('id', 'user_id', 'twitter', 'facebook', 'instagram', 'linkedin', 'youtube');
                    }
                ])->first();

        }
        else if($active_tab == 'financial') {

            $data['banks']  = Category::getCategoriesByParent('banks')->get();

            $data['lecturer'] = User::where('id', auth()->id())
                ->select( 'id')
                ->with([
                    'lecturerSetting' => function ($query) {
                        $query->select('id', 'user_id', 'bank_id', 'account_num', 'name_in_bank', 'iban');
                    }
                ])->first();

        }
        else if($active_tab == 'timetable') {
            $data['timetable'] = User::where('id', auth()->id())
                ->select( 'id')
                ->with([
                    'timeTable' => function ($query) {
                        $query->select('id', 'user_id', 'day_no', 'from', 'to');
                    }
                ])->first();
        }
        return $data;
    }



    public function update($request, $is_web = true)
    {
        try {
            $user = $this->getUser($is_web);

            $data = $request->all();
            $data['user_id'] = $user->id;

            $settings = LecturerSetting::where('user_id', $user->id)->first();

            if ($request->file('video_thumbnail')) {
                $data['video_thumbnail']           = uploadImageBySendingFile($request->file('video_thumbnail'));
            }

            $videoType = $request->input('video_type');

            if ($videoType == 'link') {

                if ($request->input('video_link')) {
                    $data['video'] = $request->input('video_link');
                }
                else if (@$settings->video_type != null && @$settings->video != null)
                {
                    $data['video_type'] = @$settings->video_type;
                    $data['video'] = @$settings->video;
                }
                else
                    $data['video_type'] = null;

            }
            elseif ($videoType == 'file') {
                if ($request->file('video_file')) {
                    $videoFile = $request->file('video_file');

                    $data['video'] = uploadvideo($videoFile);
                }
                else if (@$settings->video_type != null && @$settings->video != null)
                {
                    $data['video_type'] = @$settings->video_type;
                    $data['video'] = @$settings->video;
                }
                else
                    $data['video_type'] = null;
            }

            // dd($data);
            $item = LecturerSetting::updateOrCreate(['user_id' => $user->id], $data)->createTranslation($request);

            if($request->tab === "timetable") {
                $times = [];
                foreach($request->days as $index => $days) {
                    foreach($days as $day) {
                        $times [] = [
                            'user_id' => $user->id,
                            'day_no' => $index,
                            'from' => $day['from'],
                            'to' => $day['to']
                        ];
                    }
                }
                LecturerTimeTable::where('user_id', $user->id)->delete();
                DB::table('lecturer_time_tables')->insert($times);
            }

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;

        // $newExperty = [
        //     'id' => '2',
        //     'name' => 'test',
        //     'start_date' => 'test',
        //     'end_date' => 'test',
        //     'description' => 'test',

        // ];

        // $data = [
        //     'new_item' => $newExperty,
        //     'message' => __('message.operation_accomplished_successfully'),
        //     'status' => true,
        // ];

        // return $data;
    }

    public function setExperty($request, $is_web = true)
    {

        try {
            $user = $this->getUser($is_web);

            if ($request->id) $type = 'edit'; else $type = 'create';

            $data = $request->all();

            $data['user_id'] = $user->id;

            $item = LecturerExpertise::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'type' => $type,
                'new_item' => $item,
                'message' => $message,
                'status' => $status,
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


    public function deleteExperty($request)
    {
        try{
            $item = LecturerExpertise::find($request->id);
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

    public function setCategory($request, $is_web = true)
    {

        try {
            $user = $this->getUser($is_web);

            $data = $request->all();

            $data['user_id'] = $user->id;

            $item = UserCategory::where(['user_id' => $user->id])
                ->where('category_type', $request->category_type)
                ->where('category_id', $request->category_id)
            ->first();
            if ($item) {
                $message = __('added_previously');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }

            $item = UserCategory::updateOrCreate(['id' => $data['id']], $data);

            $new_item['id']   = $item->id;
            $new_item['name'] = @$item->category->name;

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'new_item' => $new_item,
                'message' => $message,
                'status' => $status,
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


    public function deleteCategory($request)
    {
        try{
            $item = UserCategory::find($request->id);
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
                'message' => $e->getMessage(),
                'status' => $status,
            ];
        }

        return $response;
    }
}
