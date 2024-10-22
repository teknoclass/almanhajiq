<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontSocialMedia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'social_id', 'link','icon'
    ];

}
