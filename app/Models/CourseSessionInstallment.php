<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'course_id',
        'course_session_id'
    ];

    
}
