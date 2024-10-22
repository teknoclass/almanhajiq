<?php


namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Services\CourseSessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseSessionsController extends Controller
{

    private CourseSessionService $courseSessionService;

    public function __construct(

        CourseSessionService $courseSessionService
    ) {

        $this->courseSessionService = $courseSessionService;
    }
    public function index()
    {
        $data = $this->courseSessionService->adminRequest();
        return view('panel.courses.partials.course_sessions.all',$data);
    }
    public function edit($id)
    {

        $data = $this->courseSessionService->edit($id);

        return view('panel.courses.partials.course_sessions.request', $data);
    }

    public function update( Request $request)
    {

        $response = $this->courseSessionService->respondToRequest($request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function getDataTable()
    {
        return $this->courseSessionService->getDataTable();
    }
    public function request()
    {

        $data = $this->courseSessionService->teacherRequest();


        return view('front.user.lecturer.courses.my_courses.live_lessons.partials.request', $data);
    }

    public function storePostponeRequest(Request  $request): JsonResponse
    {

        $request->validate([
            'course_session_id' => 'required|exists:course_sessions,id',
            'suggested_dates' => 'required|array|min:1',
            'suggested_dates.*' => 'date',
            'optional_files' => 'nullable|file',
        ]);

        $response = $this->courseSessionService->storePostponeRequest($request);
        return response()->json($response);
    }
    public function storeCancelRequest(Request  $request)
    {

        $request->validate([
            'course_session_id' => 'required|exists:course_sessions,id',
            'optional_files' => 'nullable|file',
        ]);
        $response = $this->courseSessionService->storeCancelRequest($request);
        return response()->json($response);
    }
    public function respondToRequest(Request  $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,pending',
            'chosen_date' => 'required_if:type,postpone|date',
        ]);
        $response = $this->courseSessionService->respondToRequest($request);
        return response()->json($response);
    }
}
