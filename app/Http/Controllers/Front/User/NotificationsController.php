<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\NotificationsEloquent;

class NotificationsController extends Controller
{
    //

    private $notifications;
    public function __construct(NotificationsEloquent $notifications_eloquent)
    {
        $this->notifications = $notifications_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->notifications->all();

        if ($request->ajax()) {
            return View::make('front.user.notifications.partials.all', $data)->render();
        }

        return view('front.user.notifications.index', $data);
    }

    public function readAll(Request $request)
    {
        $response = $this->notifications->readAll($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function read($id)
    {
        $response = $this->notifications->read($id);

        return $this->response_api($response['status'], null, null , @$response['redirect_url']);
    }


}
