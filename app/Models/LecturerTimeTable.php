<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LecturerTimeTable extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'day_no', 'from', 'to'];

    protected $appends = ['private_lessons_dates'];

    public function getFromAttribute($value)
    {
        return  Carbon::parse($value)->format('H:i');
    }

    public function getToAttribute($value)
    {
        return  Carbon::parse($value)->format('H:i');
    }

    /**
     * Get the private_lesson associated with the LecturerTimeTable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function private_lessons(): HasMany
    {
        return $this->hasMany(PrivateLessons::class, 'teacher_id', 'user_id')
            // ->where('time_form' , "$this->from")
            // ->where('time_to' , $this->to)
            ;
    }

    public function private_lessons_time(): HasMany
    {
        return $this->hasMany(PrivateLessons::class, 'teacher_id', 'user_id')
            ->whereRaw("DAYOFWEEK(meeting_date) = day_no")
            ->where(function($query){
                $query->where('time_form' , "$this->from")->orWhere('time_to' , "$this->to");
            })
            ;
    }

    // private_lessons_dates
    function getPrivateLessonsDatesAttribute() {
        return $this->private_lessons->pluck('meeting_date')->toArray();
    }
}
