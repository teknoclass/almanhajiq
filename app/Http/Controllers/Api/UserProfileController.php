<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Front\User\CoursesEloquent;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Repositories\Front\User\NotificationsEloquent;

class UserProfileController extends Controller
{

    private $courses,$notifications;

    public function __construct(CoursesEloquent $courses_eloquent,NotificationsEloquent $notifications_eloquent)
    {
        $this->courses = $courses_eloquent;
        $this->notifications = $notifications_eloquent;
    }

    public function myCourses(Request $request)
    {
        $data = $this->courses->myCourses($request, false, 9 ,true);

        $collection = new ApiCourseFilterCollection($data['courses']);

        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),$collection,Response::HTTP_OK);

        return response()->success($response);
    }

    public function myNotification(Request $request)
    {
        $data = $this->notifications->all(false);

        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data['notifications']);
    }

}
