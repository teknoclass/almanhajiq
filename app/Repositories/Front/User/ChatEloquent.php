<?php

namespace App\Repositories\Front\User;

use App\Models\Chat;
use Kreait\Firebase\Contract\Messaging;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\ChatMessages;
use App\Models\Notifications;

class ChatEloquent extends HelperEloquent
{

    protected $messaging;
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function index($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['chats'] = $data['user']->chatsOrderedByLatestMessage()->paginate(10);

        return $data;
    }

    public function create($receiver_id, $is_web = true)
    {

        $initiator = $this->getUser($is_web);

        $receiver = User::find($receiver_id);

        if (Chat::exists($initiator, $receiver)) {
            $data['chat'] = Chat::exists($initiator, $receiver);
        } else{

            if ($initiator->id == $receiver_id) {
                return abort(404);
            }

            $data['chat'] = Chat::create([
                'initiator_id' => $initiator->id,
                'partner_id' => $receiver->id
            ]);
        }

        return $data;
    }

    public function sendMessage($request, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $chat_id = $request->chat_id;

        $chat = Chat::find($chat_id);

        if ($chat->initiator_id !== $data['user']->id && $chat->partner_id !== $data['user']->id) {
            $response = [
                'status'=>false,
                'message' => 'sorry, you cannot view this chat'
            ];
            return $response;
        }

        $validator = Validator::make($request->all(), [
            'message' => 'string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $receiver = $chat->otherUser();

        if (!$receiver) {
            $response = [
                'status'=>false,
                'message' => 'Recipient not found'
            ];
            return $response;
        }

        $message            = new ChatMessages();
        $message->body      = $request->body;
        $message->sender_id = $data['user']->id;
        $message->chat_id   = $chat_id;
        $message->save();

        // Notify receiver
        $title       = 'رسالة جديدة من ' . $data['user']->name;
            $notification['title']       = $title;
            $notification['text']        = $title;
            $notification['user_type']   = 'user';
            $notification['action_type'] = 'chat';
            $notification['created_at']  = \Carbon\Carbon::now();
            $notification['user_id']     = $receiver->id;
            $notification['action_id']   = $data['user']->id;
        Notifications::insert($notification);
        sendWebNotification($receiver->id, 'user', $title, $title);


        // Broadcasting the message
        $messageData = [
            'message' => $message->body,
            'sender_image' => imageUrl($message->sender->image)
        ];

        // broadcasting the message //

        if(!empty($receiver->device_token)) {
            $message = CloudMessage::withTarget('token', $receiver->device_token)
            ->withData($messageData);
            $this->messaging->send($message);
        }

        $response = [
            'status'=>true,
            'messageData' => $messageData
        ];

        return $response;
    }



    public function saveToken($request, $is_web=true)
    {

        $input = $request->all();
        $device_token = $input['device_token'];

        $user = $this->getUser($is_web);

        $user->device_token = $device_token;
        $user->save();

        $response = [
            'success'=>true,
            'message'=>'User token updated successfully.'
        ];

        return $response;
    }
}
