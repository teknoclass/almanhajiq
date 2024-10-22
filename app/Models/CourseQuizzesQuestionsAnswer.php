<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class CourseQuizzesQuestionsAnswer extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['title'];

}
