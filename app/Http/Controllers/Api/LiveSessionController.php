<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use App\Services\PrivateLessonService;
use App\Repositories\Front\User\PrivateLessonsEloquent;
use App\Repositories\Front\User\CoursesEloquent;
use Symfony\Component\HttpFoundation\Response;

class LiveSessionController extends Controller
{
    private $courses;

    public function __construct(CoursesEloquent $courses_eloquent)
    {
        $this->courses = $courses_eloquent;
    }



    public function joinLiveSession( Request $request){

        $url = $this->courses->joinLiveSession($request,false);

        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),[
            'url' => $url
        ],Response::HTTP_OK);

        return response()->success($response);

    }

}
