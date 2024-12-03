<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Front\User\ChatEloquent;


class ChatController extends Controller
{
    protected $chats;
    public function __construct(ChatEloquent $chats_eloquest)
    {
        $this->chats = $chats_eloquest;
    }

    public function index(Request $request)
    {

        $data = $this->chats->index(false);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);

    }

    public function create($receiver_id)
    {

        $data = $this->chats->create($receiver_id,false);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    public function sendMessage(Request $request)
    {
        $response = $this->chats->sendMessage($request,false);

        return response()->json($response, 200);
    }

    public function saveToken(Request $request)
    {
        $response = $this->chats->saveToken($request,false);

        return response()->json($response);
    }

    function readMessage($id){
        $data = $this->chats->readMessage($id,false);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

}
