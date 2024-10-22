<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\PrivateLessonsRequest;
use App\Repositories\Panel\CourseRatingsEloquent;
use App\Http\Requests\Panel\CourseRatingsRequest;
use App\Repositories\Panel\PrivateLessonRatingsEloquent;
use App\Repositories\Panel\PrivateLessonsEloquent;
use App\Services\PrivateLessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PrivateLessonRequestsController extends Controller
{

    private $private_lessons_service;

    public function __construct(  PrivateLessonService $private_lessons_service)
    {
        $this->middleware('auth:admin');

        $this->private_lessons_service = $private_lessons_service;

    }
    public function index()
    {
        $data = $this->private_lessons_service->adminRequest();
        return view('panel.private_lesson_requests.all',$data);
    }
    public function edit($id)
    {

        $data = $this->private_lessons_service->edit($id);

        return view('panel.private_lesson_requests.request', $data);
    }

    public function update( Request $request)
    {

        $response = $this->private_lessons_service->respondToRequest($request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function getDataTable()
    {
        return $this->private_lessons_service->getDataTable();
    }

    public function respondToRequest(Request  $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,pending',
            'chosen_date' => 'required_if:type,postpone|date',
        ]);
        $response = $this->private_lessons_service->respondToRequest($request);
        return response()->json($response);
    }





}
