<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlidersTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','text','title_btn'];

}
