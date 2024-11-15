<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseAssignments extends Model
{
    use HasFactory , SoftDeletes , Translatable;

    protected $fillable = ['course_id', 'course_sections_id', 'user_id', 'time', 'grad', 'pass_grade', 'status','start_date','end_date'];

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
                $query->orHas('studentAssignmentResults');
            });
        });
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
        return $this->belongsTo(CourseSectionItems::class, 'id', 'item_id');
    }

    public function assignmentQuestions()
    {
        return $this->hasMany(CourseAssignmentQuestions::class, 'course_assignment_id', 'id');
    }

    public function assignmentResults()
    {
        return $this->hasMany(CourseAssignmentResults::class, 'assignment_id', 'id')->latest();
    }

    public function studentAssignmentResults()
    {
        return $this->hasMany(CourseAssignmentResults::class, 'assignment_id', 'id')->where('student_id', auth()->id())->latest();
    }

    public function scopeWithStudentStatusAndGrade($query)
    {
        $query->addSelect([
            'student_status' => CourseAssignmentResults::select('status')
                ->where('student_id', auth()->id())
                ->whereColumn('assignment_id', 'course_assignments.id')
                ->latest('created_at')
                ->limit(1),
            'student_grade' => CourseAssignmentResults::select('grade')
                ->where('student_id', auth()->id())
                ->whereColumn('assignment_id', 'course_assignments.id')
                ->latest('created_at')
                ->limit(1),
        ]);

        return $query;
    }
    public function scopeActiveStatusBasedOnUser($query)
    {
        if (Auth::guard('web')->check()) {
            if (checkUser('student')) return $query->active();
        }
    }

    public function assignmentQuestionsCount()
    {
        return $this->hasMany(CourseAssignmentQuestions::class, 'course_assignment_id', 'id')->count();
    }

}
