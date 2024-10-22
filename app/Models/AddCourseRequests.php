<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddCourseRequests extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PENDING = 'pending';

    const ACCEPTABLE = 'acceptable';

    const UNACCEPTABLE = 'unacceptable';

    protected $guarded = ['id'];


    public function course()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'courses_id');
    }
}
