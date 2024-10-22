<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseQuizzes extends Model
{
    use HasFactory , SoftDeletes , Translatable;

    protected $fillable = ['course_id', 'course_sections_id', 'user_id', 'time', 'grade', 'pass_mark', 'certificate', 'status','start_date','end_date'];

    public $translatedAttributes = ['title', 'description'];

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

    public function scopeActive($q)
    {
        return $q->where('status', 'active')
        ->orWhere(function ($query) {
            $query->when(Auth::guard('web')->check() && checkUser('student') , function ($query) {
                $query->orHas('studentQuizResults');
            });
        });
    }

    function can_delete() {
        return $this->quizResults()->count() == 0;
    }

    public function quizQuestions()
    {
        return $this->hasMany(CourseQuizzesQuestion::class, 'course_quizzes_id', 'id');
    }

    public function quizResults()
    {
        return $this->hasMany(CourseQuizzesResults::class, 'quiz_id', 'id')->latest();
    }

    public function studentQuizResults()
    {
        return $this->hasMany(CourseQuizzesResults::class, 'quiz_id', 'id')->where('user_id', auth('web')->id())->latest();
    }

    public function scopeWithStudentStatusAndGrade($query)
    {
        $query->addSelect([
            'student_status' => CourseQuizzesResults::select('status')
                ->where('user_id', auth()->id())
                ->whereColumn('quiz_id', 'course_quizzes.id')
                ->latest('created_at')
                ->limit(1),
            'student_grade' => CourseQuizzesResults::select('user_grade')
                ->where('user_id', auth()->id())
                ->whereColumn('quiz_id', 'course_quizzes.id')
                ->latest('created_at')
                ->limit(1),
        ]);

        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(CourseSections::class, 'course_sections_id', 'id');
    }

    public function section_item()
    {
        return $this->belongsTo(CourseSectionItems::class, 'id', 'itemable_id');
    }

    public function increaseTotalMark($grade)
    {
        $total_mark = $this->total_mark + $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function decreaseTotalMark($grade)
    {
        $total_mark = $this->total_mark - $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function scopeActiveStatusBasedOnUser($query)
    {
        if (Auth::guard('web')->check()) {
            if (checkUser('student')) return $query->active();
        }
    }
}
