<?php

namespace App\Helper;

use App\Models\Coupons;
use Illuminate\Support\Str;

class CouponGenerator
{
    public static function generateCoupon(): string
    {
        $generateSegment = function($length) {
            return strtoupper(Str::random($length));
        };

        do {
            $code = sprintf('%s-%s-%s-%s',
                $generateSegment(4),
                $generateSegment(5),
                $generateSegment(4),
                $generateSegment(4)
            );
        } while (Coupons::where('code', $code)->exists());

        // Create and save the coupon
        return $code;
    }
}
