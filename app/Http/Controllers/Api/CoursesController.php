<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use App\Repositories\Front\User\CoursesEloquent;
use App\Repositories\Common\CourseCurriculumEloquent;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{
    private $courses;
    private $course_curriculum;

    public function __construct(CoursesEloquent $courses_eloquent, CourseCurriculumEloquent $course_curriculum_eloquent)
    {
        $this->courses = $courses_eloquent;
        $this->course_curriculum = $course_curriculum_eloquent;
    }


    function getItemApi(Request $request , $id){
        $type = $request->get('type');
        $data = $this->course_curriculum->getItemApi($id,$type);
        
        $response = new SuccessResponse(__('message.operation_accomplished_successfully'),$data,Response::HTTP_OK);

        return response()->success($response);
    }

}
