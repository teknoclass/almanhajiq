<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'code', 'num_uses',
     'amount_type', 'amount', 'expiry_date',
    'marketer_amount_type','marketer_amount','marketer_amount_of_registration'
    ];

    public function isValid()
    {
        $is_valid = true;

        if ($this->expiry_date != '') {
            $expiry_date = \Carbon\Carbon::createFromFormat('Y-m-d', $this->expiry_date);
            $now_date = \Carbon\Carbon::now();
            if ($now_date > $expiry_date) {
                $is_valid = false;
            }
        }

        $checkNumUses = Transactios::where('coupon', $this->code)->groupBy('user_id')->count();
        if ($this->num_uses != '') {
            if ($checkNumUses > $this->num_uses) {
                $is_valid = false;
            }
        }

        return $is_valid;
    }

    public function scopeFilter($q, $search)
    {
        return $q->where('title', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%');
    }

    public function marketers()
    {
        return $this->hasMany('App\Models\CouponMarketers', 'coupon_id', 'id')
        ->where('add_by', CouponMarketers::MANUALLY);
    }

    public function allMarketers()
    {
        return $this->hasMany('App\Models\CouponMarketers', 'coupon_id', 'id');
    }

    public function marketer()
    {
        return $this->hasOne('App\Models\CouponMarketers', 'coupon_id', 'id');
    }



}
