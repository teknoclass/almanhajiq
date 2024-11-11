<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use App\Repositories\Front\User\CoursesEloquent;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller
{

    private $courses;

    public function __construct(CoursesEloquent $courses_eloquent)
    {
        $this->courses = $courses_eloquent;
    }

    public function myCourses(Request $request)
    {
        $data = $this->courses->myCourses($request, false, 9 , false);

        $collection = new ApiCourseFilterCollection($data['courses']);

        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),$collection,Response::HTTP_OK);

        return response()->success($response);
    }
}
