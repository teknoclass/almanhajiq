<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{

    protected $fillable = ['initiator_id', 'partner_id'];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessages::class, 'chat_id');
    }

    public static function exists($user1, $user2) {
        return Chat::where(function($q) use ($user1, $user2) {
            $q->where('initiator_id', $user1->id)->where('partner_id', $user2->id);
        })->orWhere(function($q) use ($user1, $user2) {
            $q->where('initiator_id', $user2->id)->where('partner_id', $user1->id);
        })->first();
    }

    public function otherUser()
    {
        $user_id = ($this->initiator_id === Auth::id()) ? $this->partner_id : $this->initiator_id;

        return User::find($user_id);
    }
    public function chatsWithMessages()
    {
        return $this->has('messages')->get();
    }

    public function lastMessage()
    {
        return $this->messages()->latest()->first();
    }

}

