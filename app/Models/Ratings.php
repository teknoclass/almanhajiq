<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ratings extends Model
{
    use HasFactory;
    use SoftDeletes;

    //sourse_type 'course','user','course_lesson','session_group_course'
    const COURSE = 'course';
    const USER='user';
    const COURSE_LESSON='course_lesson';
    const SESSION_GROUP_COURSE='session_group_course';
    const PRIVATE_LESSON='private_lesson';

    protected $fillable = ['sourse_type','sourse_id',
        'action_type','action_id',
        'user_id','rate','comment_text','is_active'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function course()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'sourse_id');
    }

    public function private_lesson()
    {
        return $this->hasOne('App\Models\PrivateLessons', 'id', 'sourse_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    // public function getDescription()
    // {

    //     $text='';
    //     if($this->sourse_type==Ratings::SESSION_GROUP_COURSE) {
    //         $item=SessionsGroupCourse::find($this->sourse_id);
    //         if($item) {
    //             $text=__('session_ratings').' ' .$item->getDate();
    //         }
    //     }
    //     return $text;
    // }
}
