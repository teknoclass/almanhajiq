<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourseLiveLesson extends Model
{
    use HasFactory , SoftDeletes , Translatable;

    protected $fillable = [
        'course_id',
        'course_sections_id',
        'user_id',
        'meeting_date',
        'time_form',
        'time_to',
        'meeting_link',
        'recording_link',
        'status',
        'meeting'
    ];

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
        return $q->where('status', 'active')
        ->orWhere(function ($query) {
            $query->when(Auth::guard('web')->check() && checkUser('student') , function ($query) {
                $query->orWhereHas('learningStatus' , function ($learningStatus) {
                    $learningStatus->where('user_id', auth('web')->id());
                });
            });
        });
    }

    function can_delete() {
        return $this->learningStatus->count() == 0;
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
                ->where('parent_id', null)->where('item_type', 'live_lesson')
                ->with(['children' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }])->active()->latest();
    }

    public function learningStatus()
    {
        return $this->hasOne(CourseLessonsLearning::class, 'lesson_id', 'id')->where('lesson_type', 'live');
    }

    public function is_completed()
    {
        $is_completed = $this->learningStatus()->where('user_id', auth()->id())->first();

        return $is_completed ? true : false;
    }

    public function attachments()
    {
        return $this->hasMany(LessonAttachment::class, 'course_lessons_id', 'id')->where('lesson_type', 'live');
    }

    public function scopeActiveStatusBasedOnUser($query)
    {
        if (Auth::guard('web')->check()) {
            if (checkUser('student')) return $query->active();
        }
    }

    public function canStartMeeting()
    {
        $check_date = false;

        $date1 = Carbon::createFromFormat("Y-m-d", $this->meeting_date)->format("Y-m-d");

        $date2 = Carbon::createFromFormat("Y-m-d", date("Y-m-d"))->format("Y-m-d");

        $time_now = Carbon::createFromFormat("H:i:s", date("H:i:s"));

        $start_time = Carbon::createFromFormat("H:i:s", $this->time_form);

        $end_time = Carbon::createFromFormat("H:i:s", $this->time_to);

        if ($date1 == $date2) {
            if ($end_time > $time_now && $start_time < $time_now) {

                $check_date=true;
            }
        }

        return $check_date;
    }

    public function getRecording()
    {
        $link = "";
        $meeting_id = 'meeting_id_' . $this->id;
        // if (env("APP_ENV") != "local") {
        $link = \Bigbluebutton::getRecordings([
            "meetingID" => $meeting_id,
            //'meetingID' => ['tamku','xyz'], //pass as array if get multiple recordings
            //'recordID' => 'a3f1s',
            //'recordID' => ['xyz.1','pqr.1'] //pass as array note :If a recordID is specified, the meetingID is ignored.
            // 'state' => 'any' // It can be a set of states separate by commas
        ]);
        // }

        return $link;
    }
}
