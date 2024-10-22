<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerSettingTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['abstract','description', 'position'];
}
