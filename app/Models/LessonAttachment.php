<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['course_lessons_id', 'attachment', 'lesson_type'];

    public function lesson()
    {
        if ($this->lesson_type === 'normal') {
            return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
        } elseif ($this->lesson_type === 'live') {
            return $this->belongsTo(CourseLiveLesson::class, 'lesson_id', 'id');
        } else {
            return null;
        }
    }

}
