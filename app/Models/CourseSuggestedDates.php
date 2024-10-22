<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSuggestedDates extends Model
{
    use HasFactory;
    public $fillable  = ['course_id','date', 'start_date','start_time'
        ,'is_active'];
}
