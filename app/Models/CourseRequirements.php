<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseRequirements extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'course_requirement_id', 'course_id'];
}
