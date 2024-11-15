<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class CourseQuizzesQuestion extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['title', 'correct'];

    static $multiple    = 'multiple';
    static $descriptive = 'descriptive';

    public function quizzesQuestionsAnswers()
    {
        return $this->hasMany(CourseQuizzesQuestionsAnswer::class, 'question_id', 'id');
    }

    public function userAnswer()
    {
        return $this->hasOne(CourseQuizzesResultsAnswers::class,'question_id','id');
    }
}
