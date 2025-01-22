<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupons;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Front\User\HomeUserEloquent;
use App\Http\Requests\Front\joinAsMarketRequestRequest;
use Illuminate\Database\Eloquent\Builder;



class MarketerHomeController extends Controller
{
    private $home_user;
    public function __construct(HomeUserEloquent $home_user_eloquent)
    {
        $this->home_user = $home_user_eloquent;
    }


    public function joinAsMarketRequest(joinAsMarketRequestRequest $request)
    {
        $response = $this->home_user->joinAsMarketRequest($request);
        return $this->response_api($response['status'], $response['message']);
    }

    public function home(Request $request)
    {
        $data = $this->home_user->MarkterHome($request,false);

        return $this->response_api(200,__('message.operation_accomplished_successfully'),$data);

    }

    public function customers(Request $request)
    {
        $data = $this->home_user->allCustomers($request);

        return $this->response_api(200,__('message.operation_accomplished_successfully'),$data);
    }

    function getReferralLink(Request $request,$id)
    {
        $course = Courses::find($id);
        $user_id = auth('api')->id();
        $url_course = route('courses.single', ['id' => @$course->id, 'title' => mergeString(@$course->title, '')]);
        $data['coupon']=Coupons::whereHas('allMarketers', function (Builder $query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->first();
        $code = $data['coupon']->code;
        $link = "$url_course?marketer_coupon=$code";
        return $this->response_api(200,__('message.operation_accomplished_successfully'),$link);
    }
}
