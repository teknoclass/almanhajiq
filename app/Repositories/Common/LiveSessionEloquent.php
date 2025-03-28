<?php

namespace App\Repositories\Common;

use App\Models\Courses;
use App\Models\CourseSession;
use App\Models\CourseSessionAttachments;
use App\Models\CourseSessionsGroup;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiveSessionEloquent  extends HelperEloquent
{

    public function editCourseSchedule($id)
    {
        $course                               = Courses::where('id', $id)->with('sessions')->first();
        $data['item']                         = $course;
        $data['item']['total_sessions']       = $course->sessions;
        $data['item']['total_sessions_count'] = $course->sessions->count();

        $data['item']['weekly_sessions_count'] = $course->sessions->groupBy('day')->count();
        $data['item']['weekly_sessions']       = $course->sessions->groupBy('day')->map->count();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }
    public function storeGroup(array $data, int $courseId)
    {
        DB::beginTransaction();

        try {

            // Create the new group
            $group = CourseSessionsGroup::create([
                'title' => $data['title'],
                'price' => $data['price'],
                'course_id' => $courseId,
            ]);

            // Assign selected sessions to the new group
            foreach ($data['sessions'] as $sessionId) {
                $session = CourseSession::findOrFail($sessionId);
                $session->group_id = $group->id;
                $session->save();
            }
            $group = $group->with('sessions')->first();
            DB::commit();

            return ['success' => true, 'message' => __('Group created successfully'), 'group' => $group];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::alert($e->getMessage());
            return ['success' => false, 'message' => __('Error creating group')];
        }
    }

    // Update an existing group and reassign sessions
    public function updateGroup(array $data, int $courseId, int $groupId)
    {
        DB::beginTransaction();

        try {
            // Find the group
            $group = CourseSessionsGroup::findOrFail($groupId);
            $group->title = $data['title'];
            $group->price = $data['price'];
            $group->save();

            // Clear existing sessions assigned to this group
            CourseSession::where('group_id', $groupId)->update(['group_id' => null]);

            // Assign new sessions to the group
            foreach ($data['sessions'] as $sessionId) {
                $session = CourseSession::findOrFail($sessionId);
                $session->group_id = $group->id;
                $session->save();
            }
            $group = $group->with('sessions')->first();
            DB::commit();

            return ['success' => true, 'message' => __('Group updated successfully'), 'group' => $group];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => __('Error updating group')];
        }
    }

    // Delete an existing group and unassign its sessions
    public function deleteGroup(int $courseId, int $groupId)
    {
        DB::beginTransaction();

        try {
            // Find the group and disassociate its sessions
            $group = CourseSessionsGroup::findOrFail($groupId);
            CourseSession::where('group_id', $groupId)->update(['group_id' => null]);
            $group->delete();

            DB::commit();

            return ['success' => true, 'message' => __('Group deleted successfully')];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => __('Error deleting group')];
        }
    }

    // Get all used sessions (those assigned to a group)
    public function getUsedSessions(int $courseId)
    {
        $usedSessions = CourseSession::where('course_id', $courseId)
            ->whereNotNull('group_id')
            ->pluck('id');

        return $usedSessions;
    }

    public function updateCourseSchedule($id, $request)
    {

        DB::beginTransaction();

        try {
            $sessionData = $request->except(['_token', 'course_id']);
            $course = Courses::find($id);
            if (!$course->published) {

                $this->setSessions($sessionData, $request, $course->id);
            }

            $message = __('schedule created');
            $status  = true;
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            $message = __('message.unexpected_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function setSessions($sessionData, $request, $course_id)
    {
        DB::transaction(function () use ($course_id) {
            DB::table('course_session_installments')
                ->whereIn('course_session_id', function ($query) use ($course_id) {
                    $query->select('id')
                        ->from('course_sessions')
                        ->where('course_id', $course_id);
                })
                ->delete();
            CourseSession::where('course_id', $course_id)->delete();
        });

        $sessionIds = [];
        $sessions = [];
        $i = 0;
        while ($i < 30) {
            if($request->has("session_day_$i")){

                $sessions[] = [
                    'day' => $request->input("session_day_$i"),
                    'date' => $request->input("session_date_$i"),
                    'time' => $request->input("session_time_$i"),
                    'title' => $request->input("session_title_$i"),
                    'id' => $request->input("session_id_$i", 0),
                    'course_id' => $course_id
                ];
            }
            $i++;
        }

        foreach ($sessions as $session) {
            if ($session['id'] == 0) {
                $session = CourseSession::create($session);

                $sessionIds[] = $session->id;
            } else {
                CourseSession::withTrashed()->where('id', $session['id'])->restore();
                CourseSession::where('id',$session['id'])->update($session);
            }
        }

        return $sessionIds;
    }

    public function publish($id)
    {
        DB::beginTransaction();

        try {
            $course = Courses::find($id);
            // Check if the course exists
            if ($course) {
                // Toggle the published status
                $course->published = !$course->published;

                // Save the changes
                $course->save();
                $message = __('Course status updated successfully');
                if (!$course->published) {
                    $groupIds = CourseSession::where('course_id', $id)
                        ->pluck('group_id')
                        ->toArray();
                    CourseSessionsGroup::whereIn('id', $groupIds)->delete();
                    CourseSession::whereIn('group_id', $groupIds)->update(['group_id' => null]);
                }
            } else {
                $message = __('Course not found');
            }
            $published = $course->published;
            $status    = true;
            DB::commit();
        } catch (\Exception $e) {

            $message   = __('error_publishing_course');
            $status    = false;
            $published = false;

            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
            'items' => $published,
        ];

        return $response;
    }

    public function createLiveSession($id, $is_web = true)
    {
        /** @var CourseSession $session***/
        $session = CourseSession::find($id);
        $type = $this->getType($is_web);
        return $session->createLiveSession($type);
    }

    public function getGroupWithSessions($request)
    {
        return CourseSessionsGroup::whereHas('sessions', function ($query) use ($request) {
            $query->where('course_id', $request->courseId);
        })->with(['sessions' => function ($query) use ($request) {
            $query->where('course_id', $request->courseId);
        }])->findOrFail($request->groupId);
    }

    function addAttachemnt($request)
    {
        $file = $request->file('file');
        $lesson_type = 'liveAttachment';
        Log::info($request->lesson_id);
        $session = CourseSession::find($request->session_id);
        $attachment = CourseSessionAttachments::create([
            'session_id' => $request->session_id,
            'original_name' => $file->getClientOriginalName(),
            'file' => uploadFile($file, 'courses/' . $session->course_id . '/' . $lesson_type)
        ]);
        return $attachment;
    }
}
