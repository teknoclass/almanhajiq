<?php

namespace App\Repositories\Panel;

use App\Models\Statistics;
use DataTables;

class StatisticsEloquent
{

    public function getDataTable()
    {



        $data = Statistics::select('id')->
        with('translations:statistics_id,title,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.statistics.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store($request)
    {

        Statistics::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

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

        $data['item'] = Statistics::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
         Statistics::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);

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
        $item = Statistics::find($id);
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
