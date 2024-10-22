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
        $query = AddCourseRequests::select('add_course_requests.*',
            DB::raw('DATE_FORMAT(add_course_requests.created_at, "%Y-%m-%d") as date'),
            'courses_translations.title as course_title',
            'users.name as lecturer_name'
        )
                                  ->leftJoin('courses', 'add_course_requests.courses_id', '=', 'courses.id')
                                  ->leftJoin('courses_translations', function($join) {
                                      $join->on('courses.id', '=', 'courses_translations.courses_id')
                                           ->where('courses_translations.locale', app()->getLocale());
                                  })
                                  ->leftJoin('users', 'courses.user_id', '=', 'users.id');

        // Apply search filtering
        $keyword = request()->get('search')['value'];
        if ($keyword) {
            $query->where(function($query) use ($keyword) {
                $query->where('courses_translations.title', 'LIKE', "%{$keyword}%")
                      ->orWhere(DB::raw('DATE_FORMAT(add_course_requests.created_at, "%Y-%m-%d")'), 'LIKE', "%{$keyword}%")
                      ->orWhere('users.name', 'LIKE', "%{$keyword}%");
            });
        }
        if ($status = request()->get('status')) {
            Log::alert($status);
            $query->where('add_course_requests.status', $status);
        }
        // Apply sorting
        if ($order = request()->get('order')) {
            $columnIndex = $order[0]['column'];
            $direction   = $order[0]['dir'];
            $columns     = [
                'add_course_requests.id', // Column index 0
                'course_title',
                'lecturer_name',
                'lecturer_name',
                'add_course_requests.status',
            ];

            if (isset($columns[$columnIndex]) && $columns[$columnIndex] !== 'add_course_requests.id') {
                $query->orderBy($columns[$columnIndex], $direction);
            }
        }
        else {
            $query->orderByDesc('add_course_requests.created_at');
        }

        return Datatables::of($query)
                         ->addIndexColumn()
                         ->addColumn('course', function($row) {
                             return $row->course_title;
                         })
                         ->addColumn('trainer', function($row) {
                             return $row->lecturer_name;
                         })
                         ->addColumn('date', function($row) {
                             return $row->date;
                         })
                         ->addColumn('status', function($row) {
                             $status = [
                                 'pending' => ['title' => __('Under Review'), 'class' => 'badge bg-dark'],
                                 'acceptable' => ['title' => __('Acceptable'), 'class' => 'badge bg-success'],
                                 'unacceptable' => ['title' => __('Unacceptable'), 'class' => 'badge bg-danger'],
                             ];

                             return '<span class="label font-weight-bold label-lg ' . $status[$row->status]['class'] . ' label-inline">' . $status[$row->status]['title'] . '</span>';
                         })
                         ->addColumn('action', 'panel.add_course_requests.partials.actions')
                         ->rawColumns(['action', 'status'])
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
                $text  = " لم يتم الموافقة على الدورة   ($course->title)";

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
