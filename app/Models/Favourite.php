<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_type',
        'source_id',
        'user_id',
        'status'
    ];

    function lecturer()
    {
        return $this->belongsTo(User::class,'source_id','id');
    }
    function course()
    {
        return $this->belongsTo(Courses::class,'source_id','id');
    }
    function blog()
    {
        return $this->belongsTo(Posts::class,'source_id','id');
    }

}
