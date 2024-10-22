<?php

namespace App\Repositories\Panel;

use App\Models\CourseRatings;
use App\Models\Ratings;
use DataTables;


class PrivateLessonRatingsEloquent
{
    public function getDataTable()
    {

        $data = Ratings::select('id','rate', 'comment_text', 'sourse_id', 'is_active','user_id', 'created_at')
            ->with('user')
            ->with('private_lesson')
            ->where('sourse_type','private_lesson')
            ->orderByDesc('created_at')->get();
             return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.private_lesson_ratings.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        $data['item'] = Ratings::where('id', $id)->where('sourse_type','private_lesson')->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {

        $data = $request->all();
        $data['date_publication'] = date("Y-m-d", strtotime($request->get('date_publication')));


        Ratings::updateOrCreate(['id' => $id], $data);

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
        $item = Ratings::find($id);
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

        $item = Ratings::find($id);
        if ($item) {
            $item->is_active = !$item->is_active;
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
