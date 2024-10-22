<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesTranslation extends Model
{
    use HasFactory;
    public $fillable  = ['title', 'description', 'welcome_text_for_registration', 'certificate_text'];
}
