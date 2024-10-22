<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSessionInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'access_until_session_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class,'id','student_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class,'id','course_id');
    }

    public function session()
    {
        return $this->belongsTo(CourseSession::class,'id','access_until_session_id');
    }
}
