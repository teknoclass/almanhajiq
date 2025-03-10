<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Coupon;

class CoursesCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'coupon_id'
    ];

    function course(){
        return $this->belongsTo(Courses::class,'course_id');
    }

    function coupon(){
        return $this->belongsTo(Coupons::class,'coupon_id');
    }

}
