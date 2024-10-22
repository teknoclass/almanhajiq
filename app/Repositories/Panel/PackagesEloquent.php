<?php

namespace App\Repositories\Panel;

use App\Models\Category;
use App\Models\Packages;
use App\Models\Setting;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\DB;

class PackagesEloquent
{

    public function getDataTable()
    {


        $data = Packages::select('id','price', 'num_hours')->with('translations:packages_id,title,locale')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.packages.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $data = $request->all();

            Packages::updateOrCreate(['id' => 0], $data)->createTranslation($request);
            DB::commit();
            $message =__('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message =__('message_error');
            $message = $e->getMessage();
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

        $data['item'] = Packages::where('id', $id)->first();

        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $page = Packages::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);
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
        $item = Packages::find($id);
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
