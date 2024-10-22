<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponMarketers extends Model
{
    use HasFactory;

    //through_request , manually

    const MANUALLY='manually';
    const THROUGH_REQUEST='through_request';

    protected $fillable = ['id', 'coupon_id','user_id'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
