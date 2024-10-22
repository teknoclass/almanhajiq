<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\ChatEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class ChatController extends Controller
{
    protected $chats;
    public function __construct(ChatEloquent $chats_eloquest)
    {
        $this->chats = $chats_eloquest;
    }

    public function index(Request $request)
    {

        $data = $this->chats->index($request);

        if ($request->ajax()) {
            return View::make('front.user.chats.partials.all', $data)->render();
        }

        return view('front.user.chats.index', $data);
    }

    public function create($receiver_id, $is_web = true)
    {

        $data = $this->chats->create($receiver_id);

        return view('front.user.chats.single', $data);
    }

    public function sendMessage(Request $request)
    {
        $response = $this->chats->sendMessage($request);

        return response()->json($response, 200);
    }

    public function saveToken(Request $request)
    {
        $response = $this->chats->saveToken($request);

        return response()->json($response);
    }
}
