<?php

namespace App\Repositories\Panel;

use DataTables;
use App\Models\Faqs;

class FaqsEloquent
{

    public function getDataTable()
    {



        $data = Faqs::select('id')->where('type', Faqs::GENERAL)
            ->with('translations:faqs_id,title,locale')->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.faqs.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store($request)
    {

        $request['order'] = Faqs::max('order') + 1;
        Faqs::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

        $message = __('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {

        $data['item'] = Faqs::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        Faqs::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);

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
        $item = Faqs::find($id);
        if ($item) {
            $item->delete();
            $message = __('delete_done');
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
