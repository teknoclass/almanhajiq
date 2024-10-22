<?php

namespace App\Repositories\Panel;


use App\Models\HomePageSettings;
use DataTables;

class HomePageSectionsEloquent
{
    public function getDataTable()
    {




        $data = HomePageSettings::orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function storeOrders($request)
    {


        $c = 1;
        foreach ($request->orderItems as $op) {
            $item = HomePageSettings::findorfail($op);
            $item->order_num = $c;
            $item->update();
            $c++;
        }


     $message =__('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }




    public function operation($request)
    {
        $id = $request->get('id');

        $item = HomePageSettings::find($id);
        if ($item) {

            $item->is_active = !@$item->is_active;
            $item->update();

         $message =__('message_done');
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
