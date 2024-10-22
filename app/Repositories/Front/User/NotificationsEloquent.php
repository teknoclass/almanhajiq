<?php

namespace App\Repositories\Front\User;

use App\Models\Notifications;
use Carbon\Carbon;

class NotificationsEloquent extends HelperEloquent
{
    public function all($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);
        // dd($data['user']);
        $data['notifications'] = Notifications::orderBy('id', 'desc')
        ->where('user_id', $data['user']->id)->where('user_type', 'user')->paginate(10);

        $this->readAll($is_web);

        return $data;
    }

    public function readAll($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        //  $notification_ids = Notifications::select('id', 'read_at')
        //     ->where('user_id', $data['user']->id)->whereNull('read_at')->pulck('id')->toArray();

        Notifications::orderBy('id', 'desc')
            ->where('user_id', $data['user']->id)->update([
                'read_at'=>Carbon::now()
            ]);

        $message = __('message.operation_accomplished_successfully');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function read($id)
    {
        $item = Notifications::where('user_id', $this->getUser(true)->id)->find($id);
        $redirect_url = null;
        if ($item) {
            // $item->update(['read_at' => carbon::now()->toDateTimeString()]);
            $redirect_url = $item->getAction();
            $status = true;
            $response = [
                'status'       => $status,
                'redirect_url' => $redirect_url,
            ];
            return $response;
        }
        $response = [
            'status'       => false,
            'redirect_url' => $redirect_url,
        ];
        return $response;
    }
}
