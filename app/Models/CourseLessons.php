<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLessons extends Model
{
    use HasFactory , SoftDeletes , Translatable;
    protected $fillable = ['course_id', 'course_sections_id', 'user_id', 'accessibility','activeDate',
                'downloadable', 'storage', 'file', 'file_type', 'volume', 'status', 'order', 'duration' ];

    public $translatedAttributes = ['title' , 'description'];

    public function createTranslation(Request $request)
    {
        foreach (locales() as $key => $language) {
            foreach ($this->translatedAttributes as $attribute) {
                if ($request->get($attribute . '_' . $key) != null && !empty($request->$attribute . $key)) {
                    $this->{$attribute . ':' . $key} = $request->get($attribute . '_' . $key);
                }
            }
            $this->save();
        }
        return $this;
    }

    public function scopeFilter($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });
    }

    public function scopeActive($q)
{
    return $q->
    where('status', 'active')
    ->orWhere(function ($query) {
        $query->when(Auth::guard('web')->check() && checkUser('student'), function ($query) {
            $query->orWhereHas('lesson_learning', function ($lesson_learning) {
                $lesson_learning->where('user_id', auth('web')->id());
            });
        });
    });
}


    function can_delete() {
        return $this->lesson_learning->count() == 0;
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(CourseSections::class, 'course_sections_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(CourseComments::class, 'item_id', 'id')
                ->where('parent_id', null)->where('item_type', 'lesson')
                ->with(['children' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }])->active()->latest();
    }

    public function lesson_learning()
    {
        return $this->hasMany(CourseLessonsLearning::class, 'lesson_id', 'id');
    }

    public function learningStatus()
    {
        return $this->hasOne(CourseLessonsLearning::class, 'lesson_id', 'id')->where('lesson_type', 'normal');
    }

    public function is_completed()
    {
        $is_completed = $this->learningStatus()->where('user_id', auth('api')->id())->first();

        return $is_completed ? true : false;
    }

    public function attachments()
    {
        return $this->hasMany(LessonAttachment::class, 'course_lessons_id', 'id')->where('lesson_type', 'normal');
    }

    public function scopeActiveStatusBasedOnUser($query)
    {
        if (Auth::guard('web')->check()) {
            if (checkUser('student')) return $query->active();
        }
    }


}
