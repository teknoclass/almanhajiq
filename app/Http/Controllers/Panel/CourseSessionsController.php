<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CoursePriceDetailsRequest;
use App\Http\Requests\Panel\CoursesRequest;
use App\Models\Courses;
use App\Models\{CourseSessionsGroup,CourseSession};
use App\Repositories\Common\CourseCurriculumEloquent;
use App\Repositories\Panel\CoursesEloquent;
use Illuminate\Http\Request;
use App\Http\Resources\CoursesResources;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CourseSessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function updateSessionPrice(Request $request)
    {
       $item = CourseSession::find($request->id);   
       if($item)
       {
            $item->price = $request->price;
            $item->save();
            return  $response = [
                'status_msg' => 'success',
                'message' => __('done_operation'),
            ];
       }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('session_not_found'),
            ];
       }
    }

    public function updateSessionDate(Request $request)
    {
       $item = CourseSession::find($request->id);   
       $isFuture = Carbon::parse($item->date . ' ' . $item->time)->isFuture();
       if(!$isFuture)
       {
        return  $response = [
            'status_msg' => 'error',
            'message' => __('session_ended'),
        ];
       }
       if($item)
       {
            $item->date = $request->date;
            $item->day = Carbon::parse($request->date)->format('l');
            $item->save();
            return  $response = [
                'status_msg' => 'success',
                'message' => __('done_operation'),
            ];
       }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('session_not_found'),
            ];
       }
    }

    public function updateSessionTime(Request $request)
    {
       $item = CourseSession::find($request->id);   
       $isFuture = Carbon::parse($item->date . ' ' . $item->time)->isFuture();
       if(!$isFuture)
       {
        return  $response = [
            'status_msg' => 'error',
            'message' => __('session_ended'),
        ];
       }
       if($item)
       {
            $item->time = $request->time;
            $item->save();
            return  $response = [
                'status_msg' => 'success',
                'message' => __('done_operation'),
            ];
       }else{
            return  $response = [
                'status_msg' => 'error',
                'message' => __('session_not_found'),
            ];
       }
    }
}