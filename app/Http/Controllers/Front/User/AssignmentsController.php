<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\AssignmentsEloquent;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{

    private $assignment;

    public function __construct(AssignmentsEloquent $assignment_eloquent)
    {
        $this->assignment = $assignment_eloquent;
    }

    public function start(Request $request, $course_id, $id)
    {
        $data = $this->assignment->start($request, $course_id, $id);

        if (@$data['error'] == 'assignment_done')
            return back()->with('message', "Assignment can't be started");

        if (@$data['error'] == 'assignment_time_passed')
            return redirect()->route('user.courses.curriculum.openByItem', ['course_id' => $data['course_id'], 'type' => 'assignment', 'id' => $data['assignment_id']]);

        return view('front.user.courses.curriculum.assignments.content', $data);
    }

    public function storeResult(Request $request, $course_id, $id)
    {
        $data = $this->assignment->storeResult($request, $course_id, $id);

        return redirect()->route('user.courses.curriculum.openByItem', ['course_id' => $data['course_id'], 'type' => 'assignment', 'id' => $data['assignment_id']]);
    }


    public function uploadFile(Request $request, $course_id)
    {
        $response = $this->assignment->uploadFile($request, $course_id);

        return $response;
    }

    public function deleteFile(Request $request, $course_id)
    {
        $response = $this->assignment->delete_file($request->file_name, $course_id);

        return $response;
    }
}
