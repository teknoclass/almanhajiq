<?php

namespace App\Repositories\Panel;


use App\Models\AddCourseRequests;
use App\Models\Courses;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AddCourseRequestsEloquent
{
    public function getDataTable()
    {
        $locale = app()->getLocale(); 
    
        $data = AddCourseRequests::select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
            ->with(['course.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale); 
            }, 'course.lecturer'])
            ->orderByDesc('created_at');
    
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('course_title', function ($row) {
                if($row->course)
                {
                    return $row->course->translations->first()->title ?? ''; 
                }else{
                    return "";
                }
            })
            ->editColumn('lecturer_name', function ($row) {
                return $row->course->lecturer->name ?? '';
            })
            ->addColumn('statusColumn', function($row) {
                $status = [
                    'pending' => ['title' => __('Under Review'), 'class' => 'badge bg-info badge-custom'],
                    'acceptable' => ['title' => __('Acceptable'), 'class' => 'badge bg-success badge-custom'],
                    'unacceptable' => ['title' => __('Unacceptable'), 'class' => 'badge bg-danger badge-custom'],
                ];

                return '<span class="label font-weight-bold label-lg ' . $status[$row->status]['class'] . ' label-inline">' . $status[$row->status]['title'] . '</span>';
            })
            ->filter(function ($query) {
                $search = request()->input('search.value');
                if ($search) {
                    $query->whereHas('course.lecturer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhereHas('course.translations', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
                    if (in_array(strtolower($search), ['acceptable', 'unacceptable'])) {
                        $query->orWhere('status', strtolower($search));
                    }
                }
               
            })
            ->addColumn('action', 'panel.add_course_requests.partials.actions')
            ->rawColumns(['action','statusColumn'])
            ->make(true);
    }
    

    public function edit($id)
    {
        $data['item'] = AddCourseRequests::where('id', $id)
                                         ->with('course')
                                         ->with('course.lecturer')
                                         ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $add_course_request = AddCourseRequests::updateOrCreate(['id' => $id], $data);

            if ($request->status == AddCourseRequests::ACCEPTABLE) {

                $course         = Courses::findorfail($add_course_request->courses_id);
                $course->status = Courses::ACCEPTED;
                $course->update();

                $title = "طلبات مراجعة الدورات ";
                $text  = " تم الموافقة على الدورة   ($course->title)";

            }
            if ($request->status == AddCourseRequests::UNACCEPTABLE) {

                $course         = Courses::findorfail($add_course_request->courses_id);
                $course->status = Courses::UNACCEPTED;
                $course->update();

                $title = "طلبات مراجعة الدورات ";
                $text  = " لم يتم الموافقة على الدورة   ($course->title)"." السبب (". $request->reason_unacceptable .")";

            }
            $user_ids[]  = $course->user_id;
            $action_type = 'add_course_request';
            $action_data = $course->id;

            $permation = '';
            $user_type = 'user';
            sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type, $user_ids);


            $message = __('message_done');
            $status  = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message  = $e->getMessage();//__('message_error');
            $status   = false;
            $error    = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($e->getMessage(), true));
            $response = [
                'message' => $message,
                'status' => $status,
            ];

        }

        return $response;
    }

    public function delete($id)
    {
        $item = AddCourseRequests::find($id);
        if ($item) {
            $item->delete();
            $message  = __('delete_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
        $message = __('message_error');
        $status  = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

}
