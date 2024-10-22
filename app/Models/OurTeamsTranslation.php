<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeamsTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'job', 'description'];
}
