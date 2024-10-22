<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssignmentResults extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    static $assignmentStatus = ['not_submitted', 'pending', 'not_passed', 'passed'];
    static $notSubmitted = 'not_submitted';
    static $pending = 'pending';
    static $notPassed = 'not_passed';
    static $passed = 'passed';

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function assignment()
    {
        return $this->belongsTo(CourseAssignments::class, 'assignment_id', 'id');
    }
}
