<?php

namespace App\Repositories\Front;

use App\Models\Coupons;
use App\Models\CoursesCoupon;
use App\Models\Transactios;
use Illuminate\Support\Facades\DB;

class CouponsEloquent
{
    public function check($code, $amount,$course_id)
    {

        $coupon = Coupons::where('code', $code)->first();

        if ($coupon == '') {
            $response=[
                'status'=>false,
                'message'=>__('message.the_coupon_is_not_valid'),
                'items'=>[
                ]
            ];
            return $response;
        }

        $checkNumUses = Transactios::where('coupon', $code)->where('status' , 'completed')->count();
        if ($coupon->num_uses != '') {
            if ($checkNumUses > $coupon->num_uses) {
                return ['status' => false,
                'data' =>__('message.the_coupon_is_not_valid') ,];
            }
        }

        $courseIds = CoursesCoupon::where('coupon_id', $coupon->id)->pluck('course_id')->toArray();

        if (count($courseIds) > 0 && !in_array($course_id, $courseIds)) {
            return ['status' => false,
                'data' =>__('message.the_coupon_is_not_valid') ,];
        }


        if (@$coupon->amount_type == 'fixed') {
            $amount_after_discount = round($amount - $coupon->amount);
        }else{
            $amount_after_discount = ($amount - ($amount * ($coupon->amount / 100)));
        }

        $total =  $amount - $amount_after_discount;

        $response=[
            'status'=>true,
            'message'=>__('message.operation_accomplished_successfully'),
            'items'=>[
                'amount_after_discount' => '' .__('currency').' ' .$amount_after_discount ,
                'amount_after_discount_2' => $amount_after_discount ,
                'total' => $total,
            ]
        ];
        return $response;
    }

    public function marketerPercentageCheck($code, $amount)
    {

        $coupon = Coupons::where('code', $code)->first();

        if ($coupon == '') {
            $response=[
                'status'=>false,
                'message'=>__('message.the_coupon_is_not_valid'),
                'items'=>[
                ]
            ];
            return $response;
        }

        $checkNumUses = Transactios::where('coupon', $code)->count();
        if ($coupon->num_uses != '') {
            if ($checkNumUses > $coupon->num_uses) {
                return response()->json(['status' => false,
                'data' =>__('message.the_coupon_is_not_valid') ,]);
            }
        }

        if (@$coupon->marketer_amount_type == 'amount') {
            $amount_after_discount = round($amount - $coupon->marketer_amount);
        }else{
            $amount_after_discount = ($amount - ($amount * ($coupon->marketer_amount / 100)));
        }

        $total =  $amount - $amount_after_discount;

        $response=[
            'status'=>true,
            'message'=>__('message.operation_accomplished_successfully'),
            'items'=>[
                'amount_after_discount' => '' .__('currency').' ' .$amount_after_discount ,
                'amount_after_discount_2' => $amount_after_discount ,
                'discount_percentage'=>$total,
                'marketer_id'=>@$coupon->marketer->user_id,
                'marketer_name'=>@$coupon->marketer->user->name,
                'total' => $total,
            ]
        ];
        return $response;
    }

}
