<?php

namespace App\Repositories\Front;

use App\Models\Admin;
use App\Models\Notifications;
use App\Models\VisitorMessage;
use Illuminate\Support\Facades\DB;

class ContactUsEloquent
{

    public function store($request)
    {

        try {

            $mobile = $request->mobile;
            if (substr($mobile, 0, 1) === "0") {
                $request['mobile']  = substr($mobile, 1);
            }

            $item=VisitorMessage::updateOrCreate(['id' => 0], $request->all());

            //sendNotification
             $notifications = [];

             $title = 'طلبات اتصل بنا';
             $text = "طلب  جديد من $request->name ";
             $notification['title'] = $title;
             $notification['text'] = $text;
             $notification['user_type'] = 'admin';
             $notification['action_type'] = 'contact_us';
             $notification['action_id'] = $item->id;
             $notification['created_at'] = \Carbon\Carbon::now();

             $admins =  Admin::all();
            foreach ($admins as $admin) {
                 if ($admin->can('show_inbox')) {
                     //sendNotification
                     $users_id[] = $admin->id;
                    $notification['user_id'] = $admin->id;
                     $notifications[] = $notification;
                 }
            }

             if (count($users_id) > 0) {
                Notifications::insert($notifications);
            //     sendWebNotifications($users_id, 'admin', $title, $text);
             }


            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            $message = 'error';
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;
    }
}
