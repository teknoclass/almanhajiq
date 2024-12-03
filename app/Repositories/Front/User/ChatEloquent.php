<?php

namespace App\Repositories\Front\User;

use App\Http\Resources\ApiChatCollection;
use App\Http\Resources\ApiGetChatResource;
use App\Http\Resources\ApiMessageCollection;
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

        if(!$is_web){
            unset($data['user']);
            $data['chats'] = new ApiChatCollection($data['chats']);
        }

        return $data;
    }

    public function create($receiver_id, $is_web = true)
    {

        $initiator = $this->getUser($is_web);

        $receiver = User::find($receiver_id);

        if (Chat::exists($initiator, $receiver)) {
            $data['chat'] = Chat::exists($initiator, $receiver);
            ChatMessages::where('chat_id',$data['chat']->id)->whereNull('read_at')->where('sender_id','!=',$initiator->id)->update(['read_at' => now()]);

        } else{

            if ($initiator->id == $receiver_id) {
                return abort(404);
            }

            $data['chat'] = Chat::create([
                'initiator_id' => $initiator->id,
                'partner_id' => $receiver->id
            ]);
        }

        if(!$is_web){
            $messages = $data['chat']->messages()->orderBy('created_at', 'DESC')->paginate(20);
            $data['messages'] = new ApiMessageCollection($messages);

            $data['chat'] = new ApiGetChatResource($data['chat']);

        }

        return $data;
    }

    public function sendMessage($request, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);
        if($is_web)$guardType = 'web';
        else $guardType = 'api';

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

        $receiver = $chat->otherUser($guardType);

        if (!$receiver) {
            $response = [
                'status'=>false,
                'message' => 'Recipient not found'
            ];
            return $response;
        }

        $message            = new ChatMessages();
        $message->body      = $request->message;
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
            'id' => (string)$message->id,
            'body' => $message->body,
            'sender_id' => (string)$message->sender_id,
            'user_name' => $message->sender->name,
            'user_image' => imageUrl($message->sender->image),
            'created_at' => $message->created_at,
            'chat_id' => (string)$message->chat_id,
            'type' => 'message'
        ];

        // broadcasting the message //
        if($is_web){

            if(!empty($receiver->device_token)) {
                $message = CloudMessage::withTarget('token', $receiver->device_token)
                ->withData($messageData);
                $this->messaging->send($message);
            }
        }else{
            $res = sendWebNotificationV2($receiver->id,'user',' رسالة جديدة من'.$message->body,$message->body,$messageData);
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

    function readMessage($id){
        ChatMessages::find($id)->readMessage();
        return;
    }
}
