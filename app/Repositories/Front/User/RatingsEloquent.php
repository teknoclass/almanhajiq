<?php

namespace App\Repositories\Front\User;

use App\Http\Resources\ApiRatingCollection;
use App\Models\PrivateLessons;
use App\Models\Ratings;
use App\Models\SessionsGroupCourse;
use App\Models\UserCourse;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RatingsEloquent extends HelperEloquent
{
    public function add($request, $is_web=true)
    {

        $message = __('message.unexpected_error');
        $status = false;
        $response = [
            'message' => $message,
            'status' => $status,
            'items'=>[],
        ];

        DB::beginTransaction();
        $data=$request->all();
        try {

            $user=$this->getUser($is_web);

            $sourse_type=$request->get('sourse_type');
            $sourse_id=$request->get('sourse_id');

            if ($sourse_type==Ratings::PRIVATE_LESSON) {

                $item=PrivateLessons::where('id', $sourse_id)->first();

            }
            else if ($sourse_type==Ratings::COURSE) {

                $item=UserCourse::where('course_id', $sourse_id)->where('user_id', $user->id)->first();

                $rating2 = new Ratings();
                $rating2->sourse_type = rATINGS::USER;
                $rating2->sourse_id = $item->course->user_id;
                $rating2->rate = $data['rate'];
                $rating2->comment_text = $data['comment_text'];
                $rating2->user_id = $user->id;
                $rating2->save();

            }


            $data['user_id']=$user->id;

            $rating = new Ratings();
            $rating->sourse_type = $data['sourse_type'];
            $rating->sourse_id = $data['sourse_id'];
            $rating->rate = $data['rate'];
            $rating->comment_text = $data['comment_text'];
            $rating->user_id = $data['user_id'];
            $rating->save();

            if($sourse_type==Ratings::PRIVATE_LESSON) {
                $item->is_rating  = 1;
                $item->save();
                $lesson_title=$item->title;
                $user_name=$user->name;


                $title = " تقييم جلستك  ($lesson_title)";
                $text = " قام $user_name بتقييم الجلسة $lesson_title";
                $user_ids[]  =$item->teacher_id;
                $action_type='private_lesson_ratings';
                $action_data=$item->teacher_id;
            }
            else if($sourse_type==Ratings::COURSE) {
                $item->is_rating  = 1;
                $item->save();
                $course_title=$item->course->title;
                $user_name=$user->name;


                $title = " تقييم دورة  ($course_title)";
                $text = " قام $user_name بتقييم الدورة  $course_title";
                $user_ids[]  =$item->lecturer_id;
                $action_type='course_ratings';
                $action_data=$item->course->id;
            }



            $permation='';
            $user_type='user';
            sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type, $user_ids);


            DB::commit();

            $message = __('message.operation_accomplished_successfully');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
                'items'=>[]
            ];


        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }


        return $response;

    }

    function get($request){
        $ratings = Ratings::active()
        ->where('sourse_id' ,$request['source_id'])->where('sourse_type',$request['source_type'])->paginate(10);

        return new ApiRatingCollection($ratings);

    }



}
