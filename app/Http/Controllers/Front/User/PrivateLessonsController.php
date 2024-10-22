<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Services\PrivateLessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\PrivateLessonsEloquent;

class PrivateLessonsController extends Controller
{
    private $private_lessons;
    private $private_lessons_service;

    public function __construct(
        PrivateLessonsEloquent $private_lessons_eloquent,
        PrivateLessonService $private_lessons_service
    ) {
        $this->private_lessons = $private_lessons_eloquent;
        $this->private_lessons_service = $private_lessons_service;
    }


    public function storePostponeRequest(Request  $request)
    {

        $request->validate([
            'private_lesson_id' => 'required|exists:private_lessons,id',
            'suggested_dates' => 'required|array|min:1',
            'suggested_dates.*' => 'date',
            'optional_files' => 'nullable|file',
        ]);

        $response = $this->private_lessons_service->storePostponeRequest($request);
        return response()->json($response);
    }
    public function storeCancelRequest(Request  $request)
    {
        $request->validate([
            'private_lesson_id' => 'required|exists:private_lessons,id',
            'optional_files' => 'nullable|file',
        ]);
        $response = $this->private_lessons_service->storeCancelRequest($request);
        return response()->json($response);
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

    public function index(Request $request, $type = 'upcoming')
    {

        $data = $this->private_lessons->index($type, package_id: $request->package_id);

        if ($request->ajax()) {
            return View::make('front.user.private_lessons.partials.all', $data)->render();
        }

        return view('front.user.private_lessons.index', $data);
    }
    public function request()
    {

        $data = $this->private_lessons_service->teacherRequest();


        return view('front.user.private_lessons.request', $data);
    }

    public function book(Request $request, $id = null)
    {
        // dd($request->all());
        $response = $this->private_lessons->book($request, $id);

        return response()->json($response);
    }

    public function joinMeeting($id)
    {
        $data = $this->private_lessons->joinMeeting($id);

        if (!$data['status']) {
            return back()->withInput();
        } else if (env('MeetingChannel') == 'AGORA') {
            return view('front.user.meeting.agora_meeting', $data);
        } else {
            return redirect($data['url']);
            return view('front.user.meeting.show_meeting', $data);
        }
    }
}
