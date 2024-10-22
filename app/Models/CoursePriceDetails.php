<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePriceDetails extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','price','discount_price'];
}
