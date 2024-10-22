<?php

namespace App\Repositories\Panel;

use App\Models\OurTeams;
use DataTables;

class OurTeamsEloquent
{
    public function getDataTable()
    {

        $data = OurTeams::select('id')->
        with('translations:our_teams_id,name,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.our_teams.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {

        OurTeams::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

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

        $data['item'] = OurTeams::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        OurTeams::updateOrCreate(['id' => $id], $request->all())
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
        $item = OurTeams::find($id);
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
