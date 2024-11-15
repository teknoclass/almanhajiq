<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizzesResultsAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'result_id',
        'question_id',
        'answer_id',
        'text_answer',
        'mark',
        'status'
    ];

    function answer()
    {
        return $this->belongsTo(CourseQuizzesQuestionsAnswer::class,'answer_id','id');
    }

    public function question()
    {
        return $this->belongsTo(CourseQuizzesQuestion::class,'question_id','id');
    }

}
