<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionsGroup extends Model
{
    use HasFactory;
    protected $table = 'course_sessions_group';
    protected $fillable = ['title', 'price'];
    public function sessions()
    {
        return $this->hasMany(CourseSession::class,'group_id');
    }

}
