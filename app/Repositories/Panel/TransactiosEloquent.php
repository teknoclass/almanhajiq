<?php

namespace App\Repositories\Panel;

use App\Models\Transactios;
use DataTables;

class TransactiosEloquent
{
    public function getDataTable()
    {

        $data = Transactios::where('is_paid' , 1)->select(
        'id',
        'description',
        'user_id',
        'payment_id',
        'amount',
        'amount_before_discount',
        'type',
        'status',
        'transactionable_type',
        'transactionable_id',
        'brand',
        'coupon',
        'created_at',
        \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date')
    )                        ->with([
        'user' => function ($query) {
            $query->select('id', 'name', 'image');
        }
    ])->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            // ->addColumn('action', 'panel.transactios.partials.actions')
            // ->rawColumns(['action'])
            ->make(true);

    }

    public function delete($id)
    {
        $item = Transactios::find($id);
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
