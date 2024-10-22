<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_session_id',
        'status',
        'subscription_date',
        'course_session_group_id',
        'related_to_group_subscription',
        'course_id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class,'id','student_id');
    }

    public function session()
    {
        return $this->belongsTo(CourseSession::class,'id','course_session_id');
    }
}
