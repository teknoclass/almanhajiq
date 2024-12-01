<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseComments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['parent_id', 'item_id', 'item_type', 'text','is_published','course_id','user_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function course()
    {
        return $this->hasOne(Courses::class, 'id', 'course_id');
    }


    public function lesson()
    {
        if ($this->item_type === 'lesson') {
            return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
        } elseif ($this->item_type === 'live_lesson') {
            return $this->belongsTo(CourseLiveLesson::class, 'lesson_id', 'id');
        } else {
            return null;
        }
    }

    public function quizz()
    {
       return $this->belongsTo(CourseQuizzes::class, 'item_id', 'id');
    }

    public function assignment()
    {
        return $this->belongsTo(CourseAssignments::class, 'item_id', 'id');
    }

    public function item()
    {
        switch ($this->item_type) {
            case 'lesson':
                return $this->lesson();
            case 'quizz':
                return $this->quiz();
            case 'assignment':
                return $this->assignment();
            default:
                return null;
        }
    }


    public function scopeActive($query)
    {
        return $query->where('is_published', 1);
    }

    public function parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(self::class, 'parent_id')->where('parent_id', '!=', null);
    }

    function hasReply(){

        if(CourseComments::where('parent_id',$this->id)->exists()){
            return true;
        }else{
            return false;
        }

    }
}
