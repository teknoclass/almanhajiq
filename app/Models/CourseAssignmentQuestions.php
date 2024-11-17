<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class CourseAssignmentQuestions extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['title'];


    static $assignmentType = ['text', 'file'];
    static $text = 'text';
    static $file = 'file';

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assignment()
    {
        return $this->belongsTo(CourseAssignments::class, 'course_assignment_id', 'id');
    }

    function userAnswers()
    {
        return $this->hasOne(CourseAssignmentsResultsAnswer::class,'question_id','id');
    }

}
