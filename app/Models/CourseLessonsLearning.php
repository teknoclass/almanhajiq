<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLessonsLearning extends Model
{
    use HasFactory , SoftDeletes;

    protected           $fillable = ['user_id', 'lesson_id', 'lesson_type'];

    public function lesson()
    {
        if ($this->lesson_type === 'normal') {
            return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
        } elseif ($this->lesson_type === 'live') {
            return $this->belongsTo(CourseSession::class, 'lesson_id', 'id');
        } else {
            return null;
        }
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
