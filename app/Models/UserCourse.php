<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UserCourse extends Model
{
    use HasFactory;

    //register_sourse : 'website','admin'
    public const REGISTER_FROM_WEBSITE='website';

    public const REGISTER_FROM_ADMIN='admin';

    protected $fillable = [
        'user_id',
        'course_id',

        'pay_transaction_id','is_paid',

        'level_id',
        'lecturer_id',
        'suggested_date_id',
        'group_id',
        'num_students',
        'progress',
        'subscription_token',
        'num_lessons',
        'is_end',
        'is_get_certificate',
        'certificate_issued_at',
        'is_rating',
        'is_rating_lecturer',
        'is_complete_payment',
        'is_free_trial',
        'num_free_lessons_allowed',
        'register_sourse',
        'register_by',
        'is_lecturer_add_appointments',
        'is_installment'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function level()
    {
        return $this->hasOne('App\Models\Category', 'value', 'level_id')
        ->where('parent', 'course_levels');
    }

    public function lecturer()
    {
        return $this->hasOne('App\Models\User', 'id', 'lecturer_id');
    }


    public function course()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'course_id');
    }

    public function scopeFilter($q, $search)
    {
        return $q->whereHas('user', function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })
        ->orWhereHas('course', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });
    }

    public function suggestedDate()
    {

        return $this->hasOne('App\Models\CourseSuggestedDates', 'id', 'suggested_date_id');

    }

    //SessionsGroupCourse


    public function SessionsGroup()
    {

        return $this->hasOne('App\Models\SessionsGroupCourse', 'user_course_id', 'id');

    }

    public function canRateCourse()
    {

        $item=$this;
        if(
            $item->is_rating==0
            &&
            $item->is_end==1
            &&
            $item->user_id==getUser()->id
        ) {

            return true;
        }

        // return false;
        return true;

    }

    public function canRateLecturer()
    {

        $item=$this;
        if(
            $item->is_rating_lecturer==0
            &&
            $item->is_end==1
            &&
            $item->user_id==getUser()->id
        ) {

            return true;
        }

        // return false;
        return true;

    }

    public function createGroup(){

        $user_course=$this;
        $course=$user_course->course;
        $course_id=$course->id;
        $user_id=getUser()->id;
        $suggested_date=$user_course->suggestedDate;

        $num_group=CourseGroups::max('id')+1;

        $name_group=$course->title .' ('.time().$num_group.')';

        // create group
        $course_group=CourseGroups::create([
            'course_id'=>$course_id,
            'user_id'=>$user_id,
            'user_course_id'=>$user_course->id,
            'name'=>$name_group,
            'num_students'=>0,
            'start_date'=> date('Y-m-d', strtotime($suggested_date->start_date)),
            'start_time'=>$suggested_date->start_time,
        ]);

        SessionsGroupCourse::create( [
            'course_group_id'=>$course_group->id,
            'course_id'=>$course_id,
            'user_course_id'=>$user_course->id,
            'start_date' =>date('Y-m-d', strtotime($suggested_date->start_date)),
            'start_time' => $suggested_date->start_time,
            'week_num'=>1,
            'session_duration'=>@$course->session_duration_minutes,
            'type'=>SessionsGroupCourse::INTRODUCTORY_MEETING
        ]);

        return true;
    }

    /**
     * Get the transaction that owns the UserCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactios::class, 'pay_transaction_id');
    }

}
