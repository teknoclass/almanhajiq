<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesTranslation extends Model
{

    use HasFactory;
    public $fillable  = ['title', 'description'];
}
