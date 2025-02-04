<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionAttachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_name',
        'file',
        'session_id'
    ];

    function session(){
        return $this->belongsTo(CourseSession::class,'session_id');
    }
}
