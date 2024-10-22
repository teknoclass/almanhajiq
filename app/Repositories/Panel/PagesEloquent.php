<?php

namespace App\Repositories\Panel;

use App\Models\Pages;
use DataTables;
use Illuminate\Support\Facades\DB;

class PagesEloquent
{

    public function getDataTable()
    {


        $data = Pages::select('id')->with('translations:pages_id,title,locale')->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.pages.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {

            Pages::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);
            DB::commit();
            $message =__('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message =__('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {

        $data['item'] = Pages::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $page = Pages::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);
            DB::commit();
            $message =__('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message =__('message_error');
            $status = false;
            DB::rollback();
       }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($id)
    {
        $item = Pages::find($id);
        if ($item) {
            if ($item->can_delete == 1) {
                $item->delete();
                $message =__('delete_done');
                $status = true;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }
            else{
                $message =__('delete_page_error');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }
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
