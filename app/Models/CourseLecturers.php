<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLecturers extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','user_id','is_active'];

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function course(){
        return $this->hasOne('App\Models\Courses', 'id', 'course_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
