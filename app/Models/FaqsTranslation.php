<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqsTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','text'];
}
