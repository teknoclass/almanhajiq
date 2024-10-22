<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorMessageReplays extends Model
{
    use HasFactory;

    protected $fillable=['admin_id', 'message_id', 'text',];
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id')->withDefault();
    }

    public function message()
    {
        return $this->belongsTo(VisitorMessage::class, 'message_id', 'id')->withDefault();
    }

    public function diffForHumans() {

        return (is_string($this->created_at)) ? \Carbon\Carbon::createFromTimestampUTC(strtotime($this->created_at))->diffForHumans() : $this->created_at->diffForHumans();

    }
}
