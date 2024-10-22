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

}