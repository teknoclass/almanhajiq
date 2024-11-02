<?php

namespace App\Repositories\Panel;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Panel\RoleRequest;
use DataTables;
use Illuminate\Support\Facades\DB;

class RolesEloquent
{


    public function getDataTable()
    {
        $data = Role::select('id','name')->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.roles.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }



    public function store($request)
    {


        DB::beginTransaction();
        try {


            $role = new Role();
            $role->name = $request->name;
            $role->save();

            $role->syncPermissions($request->permissions);

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

        $data['item'] = Role::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {

        DB::beginTransaction();
        try {

            $role = new Role();
            $role = $role->updateOrCreate(['id' => $id], $request->all());
            $role->syncPermissions($request->permissions);
            
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

        $item = Role::find($id);
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
