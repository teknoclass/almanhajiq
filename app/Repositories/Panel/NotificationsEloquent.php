<?php

namespace App\Repositories\Panel;

use App\Models\Notifications;
use Carbon\Carbon;
use DataTables;
use Auth;

class NotificationsEloquent
{
    public function getDataTable()
    {
        $user =  Auth::user();
        $data = Notifications::where('user_id', $user->id)->where('user_type', 'admin')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addColumn('sdate', ' {{ diffForHumans($created_at) }}')
            ->addIndexColumn()
            ->addColumn('action', 'panel.notifications.partials.actions')
            ->rawColumns(['action'])
            ->make(true);


    }


    public function delete($id)
    {
        $item = Notifications::find($id);
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

    public function read($id)
    {
        $user =  auth()->user();
        $item = Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')->find($id);
        $redirect_url = null;
        if ($item) {
            $item->update(['read_at' => carbon::now()->toDateTimeString()]);
            $redirect_url = $item->getAction();
            $status = true;
            $response = [
                'status'       => $status,
                'redirect_url' => $redirect_url,
            ];
            return $response;
        }
        $response = [
            'status'       => true,
            'redirect_url' => $redirect_url,
        ];
        return $response;
    }

    public function readAll()
    {
        $user =  auth()->user();

        if ($user) {
            Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')->orderBy('id', 'desc')->update([
                'read_at' => carbon::now()->toDateTimeString()
            ]);
            return true;
        }
        return false;
    }



}
