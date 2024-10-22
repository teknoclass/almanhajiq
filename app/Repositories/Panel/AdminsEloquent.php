<?php

namespace App\Repositories\Panel;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DataTables;

class AdminsEloquent
{

    public function getDataTable()
    {
        $data = Admin::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.admins.partials.actions')
            ->rawColumns(['action'])
            ->make(true);

    }


    public function store($request)
    {
        DB::beginTransaction();
        try {


            if (filled($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            }

            //role
            $role_id = $request->get('role_id');
            $role = Role::find($role_id);



            $admin = Admin::create($request->all());

            $admin->assignRole($role);

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
        $data['item'] = Admin::find($id);
        $data['roles'] = DB::table('roles')->get();

        return $data;
    }




    public function update($id, $request)
    {
        DB::beginTransaction();
        try {



            if (!filled($request->image)) {
                $request->image = 'avatar.png';
            }



            if (($request['password']) != null) {
                $request['password'] = Hash::make($request['password']);
            } else {
                unset($request['password']);
            }
            $admin = Admin::find($id);

            if (isset($admin)) {

                //role
                $role_id = $request->get('role_id');
                $role = Role::find($role_id);
                $admin->roles()->detach();
                $admin->assignRole($role);

                $admin->update($request->all());
            }

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
        $item = Admin::find($id);
        if ($item) {
            $item->delete();
            $message = 'تم الحذف بنجاح  ';
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
