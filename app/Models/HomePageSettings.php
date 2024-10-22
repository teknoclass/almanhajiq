<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSettings extends Model
{
    use HasFactory;
    protected $fillable = ['title','section_key','order_num','is_active'];

}
