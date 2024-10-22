<?php

namespace App\Repositories\Panel;

use App\Models\WorkSteps;
use DataTables;

class WorkStepsEloquent
{
    public function getDataTable()
    {

        $data = WorkSteps::select('id')->
        with('translations:work_steps_id,text,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.work_steps.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store($request)
    {

        WorkSteps::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

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

        $data['item'] = WorkSteps::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        WorkSteps::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);

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
        $item = WorkSteps::find($id);
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
