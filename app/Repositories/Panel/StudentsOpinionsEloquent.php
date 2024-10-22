<?php

namespace App\Repositories\Panel;

use App\Models\StudentsOpinions;
use DataTables;
class StudentsOpinionsEloquent
{
    public function getDataTable()
    {


        $data = StudentsOpinions::select('id')
            ->with('translations:students_opinions_id,text,name,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->rawColumns(['text'])
            ->addIndexColumn()
            ->addColumn('action', 'panel.students_opinions.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {

        StudentsOpinions::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

        $message =__('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {

        $data['item'] = StudentsOpinions::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        $page = StudentsOpinions::updateOrCreate(['id' => $id], $request->all())
        ->createTranslation($request);

        $message =__('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($id)
    {
        $item = StudentsOpinions::find($id);
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
