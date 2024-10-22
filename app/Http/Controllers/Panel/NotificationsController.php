<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\NotificationsEloquent;
use App\Repositories\Panel\TransactiosEloquent;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //

    private $notifications;
    public function __construct(NotificationsEloquent $notifications_eloquent)
    {
        $this->middleware('auth:admin');

        $this->notifications = $notifications_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.notifications.all');
    }


    public function getDataTable()
    {
        return $this->notifications->getDataTable();
    }

    public function delete($id)
    {
        $response = $this->notifications->delete($id);

        return $this->response_api($response['status'], $response['message']);
    }

    public function read($id)
    {
        $response = $this->notifications->read($id);

        return $this->response_api($response['status'], null , null , $response['redirect_url']);
    }
    public function readAll()
    {
        $response = $this->notifications->readAll();

        return back()->with(['success' , 'Done']);
    }

}
