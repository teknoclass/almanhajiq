<?php

namespace App\Repositories\Panel;

use App\Models\Sliders;
use DataTables;

class SlidersEloquent
{

    public function getDataTable()
    {

        $data =  Sliders::whereName('header')->select('id', 'image', 'background', 'link')
                         ->with('translations:sliders_id,title,text,locale,title_btn')
                         ->orderByDesc('created_at')->get();

        return Datatables::of($data)
             ->addIndexColumn()
            ->addColumn('action', 'panel.sliders.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create($type)
    {

        switch ($type) {
            case 'header':
                $data['title_heading'] = "هيدر الرئيسية";
                $data['name'] = "header";
                break;

            default:
                break;
        }

        return $data;
    }


    public function store($request)
    {

        Sliders::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

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

        $data['item'] = Sliders::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        Sliders::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);

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
        $item = Sliders::find($id);
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
