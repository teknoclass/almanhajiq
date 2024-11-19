<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Repositories\Front\CouponsEloquent;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    private $coupons;

    function __construct(CouponsEloquent $coupon_eloquent)
    {
        $this->coupons = $coupon_eloquent;
    }


    function check(Request $request){

        $data = $this->coupons->check($request->get('code'),$request->get('amount'));

        if($data['status']){
            $response = new SuccessResponse($data['message'] , $data['items'] , Response::HTTP_OK);
            return response()->success($response);
        }else{
            $response = new ErrorResponse($data['message'],Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }


    }



}
