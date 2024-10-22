<?php

namespace App\Repositories\Panel;

use App\Models\OurMessages;
use DataTables;

class OurMessagesEloquent
{
    public function getDataTable()
    {


        $data = OurMessages::select('id')
            ->with('translations:our_messages_id,title,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.our_messages.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {

        OurMessages::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

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

        $data['item'] = OurMessages::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        $page = OurMessages::updateOrCreate(['id' => $id], $request->all())
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
        $item = OurMessages::find($id);
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
