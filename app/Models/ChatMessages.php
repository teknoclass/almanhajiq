<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'sender_id', 'body'];


    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    function readMessage()
    {
        $this->read_at = now();
        $this->save();
        return true;
    }
}
