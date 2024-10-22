<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    const STUDENT='student';
    const LECTURER='lecturer';
    const MARKETER='marketer';

    protected $fillable = [
        'user_id', 'role'
    ];

    
}
