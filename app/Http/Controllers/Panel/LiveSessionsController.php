<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\CourseSession;
use App\Models\CourseSessionAttachments;
use App\Repositories\Common\LiveSessionEloquent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class LiveSessionsController extends Controller
{
    protected $liveSessionService;

    // Inject the LiveSessionEloquent service
    public function __construct(LiveSessionEloquent $liveSessionService)
    {
        $this->liveSessionService = $liveSessionService;
    }
    public function storeGroup(Request $request, int $courseId): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sessions' => 'required|array|min:1',
        ]);

        $result = $this->liveSessionService->storeGroup($validatedData, $courseId);

        if ($result['success']) {
            return response()->json(['message' => $result['message'], 'group' => $result['group'],'success' => $result['success']], 200);
        }

        return response()->json(['message' => $result['message'],'success' => $result['success']], 500);
    }

    // Update an existing group
    public function updateGroup(Request $request, int $courseId, int $groupId): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sessions' => 'required|array|min:1',
        ]);

        $result = $this->liveSessionService->updateGroup($validatedData, $courseId, $groupId);

        if ($result['success']) {
            return response()->json(['message' => $result['message'],'group' => $result['group'],'success' => $result['success']], 200);
        }

        return response()->json(['message' => $result['message'],'success' => $result['success']], 500);
    }

    // Delete a group
    public function deleteGroup(int $courseId, int $groupId): JsonResponse
    {
        $result = $this->liveSessionService->deleteGroup($courseId, $groupId);

        if ($result['success']) {
            return response()->json(['message' => $result['message'],'success' => $result['success']], 200);
        }

        return response()->json(['message' => $result['message'],'success' => $result['success']], 500);
    }

    // Get all used sessions (those that have been assigned to a group)
    public function getUsedSessions(int $courseId): JsonResponse
    {
        $usedSessions = $this->liveSessionService->getUsedSessions($courseId);

        return response()->json(['used_sessions' => $usedSessions]);
    }
    public function getGroupWithSessions(Request $request): JsonResponse
    {
        // Fetch the group and its associated sessions
        $group = $this->liveSessionService->getGroupWithSessions($request);

        return response()->json([
            'success'=>true,
            'group' => $group,
            'sessions' => $group->sessions,  // Include the group's sessions
        ]);
    }

    function getAttachmentModal()
    {
        $id = request()->query('session_id');
        $data = CourseSessionAttachments::where('session_id',$id)->get();
        $session = CourseSession::find($id);
        $content = View::make('front.user.lecturer.courses.my_courses.create.components.schedule.modals.attachment.attachment',['attachments' => $data,'session' => $session])->render();
        return response()->json(['content' => $content]);

    }

    function deleteAttachemnt(Request $request){
        $attachment = CourseSessionAttachments::find($request['id']);
        $attachment->delete();
        return response()->json([
            'success'=>true,
            'message' => __('message.success')
        ]);
    }

    function addAttachemnt(Request $request){
        $data = $this->liveSessionService->addAttachemnt($request);
        return response()->json([
            'success'=>true,
            'attachment' => $data,
            'message' => __('message.success')
        ]);
    }
}
