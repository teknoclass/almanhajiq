<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssignmentsResultsAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['file','answer','question_id','result_id','mark'];

    function question()
    {
        return $this->belongsTo(CourseAssignmentQuestions::class,'question_id','id');
    }

    function result()
    {
        return $this->belongsTo(CourseAssignmentResults::class,'result_id','id');
    }

}
