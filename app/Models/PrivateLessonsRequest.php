<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateLessonsRequest extends Model
{
    protected $fillable = [
        'private_lesson_id', 'user_id', 'user_type', 'type', 'suggested_dates', 'optional_files', 'status', 'chosen_date', 'admin_response'
    ];

    protected $casts = [
        'suggested_dates' => 'array',
        'optional_files' => 'array',
    ];

    public function privateLesson()
    {
        return $this->belongsTo(PrivateLessons::class,'private_lesson_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStudent($query)
    {
        return $query->where('user_type', 'student');
    }
    public function scopeTeacher($query)
    {
        return $query->where('user_type', 'teacher');
    }
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('user_id', $studentId)->where('user_type', 'student');
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('user_id', $teacherId)->where('user_type', 'teacher');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

}
