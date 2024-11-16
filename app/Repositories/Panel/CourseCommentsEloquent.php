<?php

namespace App\Repositories\Panel;

use App\Models\CourseComments;
use DataTables;


class CourseCommentsEloquent
{
    public function getDataTable()
    {
        $query = CourseComments::select('course_comments.id', 'course_comments.text', 'course_comments.course_id', 'course_comments.is_published', 'course_comments.user_id')
                               ->with('user')
                               ->with('course')
                               ->leftJoin('users', 'course_comments.user_id', '=', 'users.id')
                               ->leftJoin('courses', 'course_comments.course_id', '=', 'courses.id')
                               ->leftJoin('courses_translations', 'courses.id', '=', 'courses_translations.courses_id')
                               ->where('courses_translations.locale', app()->getLocale());

        // Apply global search
        if ($keyword = request()->get('search')['value']) {
            $query->where(function($q) use ($keyword) {
                $q->where('course_comments.text', 'LIKE', "%{$keyword}%")
                  ->orWhere('users.name', 'LIKE', "%{$keyword}%")
                  ->orWhere('courses_translations.title', 'LIKE', "%{$keyword}%");
            });
        }

        // Apply sorting
        if ($order = isset(request()->get('order')[0]) ?? "" ) {
            $orderColumnIndex = $order['column'];
            $orderDirection = $order['dir'];

            // Define the columns you want to sort by
            $columns = [
                0 => 'course_comments.text',
                1 => 'users.name',
                2 => 'courses_translations.title',
                3 => 'course_comments.is_published'
            ];

            // Get the column name for sorting
            $orderColumn = $columns[$orderColumnIndex] ?? 'course_comments.created_at'; // Default to 'created_at' if index is invalid

            // Apply sorting to the query
            $query->orderBy($orderColumn, $orderDirection);
        } else {
            $query->orderByDesc('course_comments.created_at'); // Default sorting
        }

        // Get paginated data
        $data = $query->get();

        return Datatables::of($data)
                         ->addIndexColumn()
                         ->addColumn('user', function ($row) {
                             return $row->user ? $row->user->name : '';
                         })
                         ->addColumn('course', function ($row) {
                             return $row->course ? $row->course->title : '';
                         })
                         ->addColumn('is_published', function ($row) {
                             $checked = $row->is_published ? 'checked' : '';
                             return '<div class="form-check form-switch form-check-custom form-check-solid">' .
                                 '<span class="switch">' .
                                 '<label>' .
                                 '<input class="form-check-input" type="checkbox" ' . $checked . ' name="select" id="is_published" />' .
                                 '<span></span></label>' .
                                 '<input value="' . $row->id . '" type="hidden" class="item_id">' .
                                 '</div>';
                         })
                         ->addColumn('action', 'panel.course_comments.partials.actions')
                         ->rawColumns(['is_published', 'action'])
                         ->make(true);
    }




    public function getDataTableCourse($course_id)
    {

         $data = CourseComments::select('id', 'text', 'course_id', 'is_published','user_id')
            ->with('user')
            ->with('course')
            ->where('course_id',$course_id)
            ->orderByDesc('created_at')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.course_comments.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }



    public function edit($id)
    {
        $data['item'] = CourseComments::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {

        $data = $request->all();
        $data['date_publication'] = date("Y-m-d", strtotime($request->get('date_publication')));

        // dd($request->text_ar);

        CourseComments::updateOrCreate(['id' => $id], $data);

        $message = __('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function delete($id)
    {
        $item = CourseComments::find($id);
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
        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function operation($request)
    {
        $id = $request->get('id');

        $item = CourseComments::find($id);
        if ($item) {
            $item->is_published = !$item->is_published;
            $item->update();
            $message = __('message_done');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
