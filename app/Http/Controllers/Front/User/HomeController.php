<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Front\User\HomeUserEloquent;
use Illuminate\Http\Request;
use App\Models\CourseSession;

class HomeController extends Controller
{
    private $home_user;
    public function __construct(HomeUserEloquent $home_user_eloquent)
    {
        $this->home_user = $home_user_eloquent;
    }

    public function index(Request $request)
    {
        $user=auth('web')->user();

        if ($user->role == User::STUDENTS) {

            $data = $this->home_user->index($request, User::STUDENTS);

            return view('front.user.home_user.student' , $data);

        } elseif($user->role == User::LECTURER) {

            $data = $this->home_user->index($request, User::LECTURER);

            return view('front.user.home_user.lecturer', $data);
        }
        // هنا يجب ان يكون فقط هو مسوق لانه ممكن يكون هو مسوق و محاضر
        elseif($user->role == User::MARKETER) {

            $data = $this->home_user->index($request, User::MARKETER);

            return view('front.user.home_user.marketer', $data);
        }
        elseif($user->role == User::PARENT) {

            $data = $this->home_user->index($request, User::PARENT);

            return view('front.user.home_user.parent', $data);
        }
    }

    public function cart()
    {
        return view('front.user.cart.index');
    }

    public function settings()
    {
        return view('front.user.settings.index');
    }

    public function my_points()
    {
        return view('front.user.points.index');
    }

    public function my_purchases()
    {
        return view('front.user.purchases.index');
    }

    public function payment()
    {
        return view('front.user.payment.index');
    }

    public function certificate()
    {
        return view('front.user.certificates.index');
    }

    public function meetingFinished($meeting_id = 0 , $user_id = 0)
    {
        $lesson = CourseSession::where('id', $meeting_id)->first();
        $lesson->meeting_status = "finished";
        $lesson->update();

        $this->home_user->meetingFinished($meeting_id , $user_id );

        return view('front.components.meeting_finished');
    }
}
