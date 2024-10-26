<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseSessionsGroup extends Model
{
    use HasFactory;
    protected $table = 'course_sessions_group';
    protected $fillable = ['title', 'price'];
    public function sessions()
    {
        return $this->hasMany(CourseSession::class,'group_id');
    }
    public function canAccess($userId)
    {
        return DB::table('course_session_subscriptions')
                 ->where('student_id', $userId)
                 ->where('course_session_group_id', $this->id)
                 ->where('related_to_group_subscription', 1)
                 ->exists();
    }
}
