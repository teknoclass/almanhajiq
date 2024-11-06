<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LecturerCollection;
use App\Http\Resources\TeacherCollection;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use App\Repositories\Front\LecturersEloquent;
use Symfony\Component\HttpFoundation\Response;

class LecturerController extends Controller
{

    private $lecturers;
    public function __construct(LecturersEloquent $lecturers_eloquent)
    {
        $this->lecturers = $lecturers_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->lecturers->getData($request);

        $collection = new TeacherCollection($data['lecturers']);

        $respone = new SuccessResponse(__('message.operation_accomplished_successfully'),$collection,Response::HTTP_OK);

        return response()->success($respone);


    }



}
