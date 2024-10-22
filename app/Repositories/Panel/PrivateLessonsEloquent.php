<?php

namespace App\Repositories\Panel;

use App\Models\Category;
use App\Models\PrivateLessons;
use App\Models\Setting;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\DB;

class PrivateLessonsEloquent
{

    public function getDataTable()
    {


        $data = PrivateLessons::select('id','category_id','student_id','teacher_id', 'meeting_type', 'meeting_date', 'time_form', 'time_to', 'status')->with('translations:private_lessons_id,title,locale')
            ->with(['teacher','student','category'])->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.private_lessons.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $data['categories'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'course_categories')
            ->orderByDesc('created_at')->get();

        $data['support_offline_lessons'] = Setting::where('key', 'offline_private_lessons')->first()->value;


        return $data;
    }
    public function store($request)
    {
        DB::beginTransaction();
        try {

            $data = $request->all();

            $user = User::find($data['teacher_id']);

            if (!$request->price){
                $data['price'] = 0;
            }

            if ($request->student_id){
                $data['status'] = 'acceptable';
            }

            for ($i = 0; $i < count($request->meeting_date); $i++) {
                if(strtotime($request->time_form[$i])>=strtotime($request->time_to[$i])) {
                    $message = "وقت انتهاء الدرس يجب أن يكون أكبر من وقت البدء";
                    $response = [
                        'message' => $message,
                        'status' => false,
                    ];

                    return $response;
                }
                $data['meeting_date'] = $request->meeting_date[$i];
                $data['time_form'] = $request->time_form[$i];
                $data['time_to'] = $request->time_to[$i];
                PrivateLessons::updateOrCreate(['id' => 0], $data)->createTranslation($request);
            }

            DB::commit();
            $message =__('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message =__('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {

        $data['item'] = PrivateLessons::where('id', $id)->first();

        if ($data['item'] == '') {
            abort(404);
        }

        $data['categories'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'course_categories')
            ->orderByDesc('created_at')->get();

        $data['support_offline_lessons'] = Setting::where('key', 'offline_private_lessons')->first()->value;

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $page = PrivateLessons::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);
            DB::commit();
            $message =__('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message =__('message_error');
            $status = false;
            DB::rollback();
       }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($id)
    {
        $item = PrivateLessons::find($id);
        if ($item) {

                $item->delete();
                $message =__('delete_done');
                $status = true;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;

        }
        $message =__('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
