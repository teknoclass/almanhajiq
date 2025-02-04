<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    function session(){
        return $this->belongsTo(CourseSession::class,'session_id');
    }
}
