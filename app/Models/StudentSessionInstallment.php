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
        return $this->belongsTo(User::class,'student_id','id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id','id');
    }

    public function session()
    {
        return $this->belongsTo(CourseSession::class,'access_until_session_id','id');
    }
}
