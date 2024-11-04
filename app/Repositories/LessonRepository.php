<?php

namespace App\Repositories;

use App\Models\CourseCurriculum;
use App\Models\CourseLessons;
use App\Models\Courses;
use App\Models\CourseSectionItems;
use App\Models\CourseSession;
use App\Models\LessonAttachment;
use App\Services\FileUploadService;
use App\Services\ItemService;
use App\Traits\Transactional;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LessonRepository extends BaseRepository
{
    use Transactional;

    public CourseSession $courseSession;

    public function __construct(CourseSession $courseSession)
    {

        $this->courseSession = $courseSession;
    }

    public function addLesson($request, $is_web = true): array
    {
        return $this->executeTransaction(function () use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);
            $data['file'] = FileUploadService::handleFileUpload($data,$request, $data['course_id'], $data['file_type'], $data['video_type'] ?? null);

           $data['storage'] = $data['video_type'] ?? null;

            $data['duration'] = $this->getDuration($data, $request);
            $data['downloadable'] = isset($data['downloadable']) ? 1 : 0;
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';
            $item = CourseLessons::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);
            Log::alert($data['status']);
            $this->handleAttachments($request, $data, $item);

            ItemService::storeSectionItem($data, $item,CourseLessons::class);

            $this->notify_registered_users($request->course_id);

            return $this->response(__('message.operation_accomplished_successfully'), true);
        });
    }
    public function updateLesson($request, $is_web = true): array
    {
        return $this->executeTransaction(function () use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);

            $data['downloadable'] = isset($data['downloadable']) ? 1 : 0;
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';
            if($request->file('upload'))
            {
                $data['file'] = FileUploadService::handleFileUpload($data,$request, $data['course_id'], $data['file_type'], $data['video_type'] ?? null);
            }else{
                $data['file'] = CourseLessons::find( $data['id'])->file ?? "";
            }

            $item = CourseLessons::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            $this->handleAttachments($request, $data['course_id'], $item);

            $message = __('message.operation_accomplished_successfully');
            $status = true;
            return $this->response($message, $status);
        });
    }
    public function deleteLesson($request): array
    {
        return $this->executeTransaction(function () use ($request) {
            $item = CourseLessons::find($request->id);

            if ($item) {
                CourseSectionItems::where(['itemable_id' => $item->id, 'itemable_type' => config("constants.item_types.$item->itemable_type")])->delete();
                $item->delete();
                $message = __('delete_done');
                $status = true;
            } else {
                $message = __('message.item_not_found');
                $status = false;
            }

            return $this->response($message, $status);
        });
    }

    public function deleteOuterLesson($request): array
    {
        return $this->executeTransaction(function () use ($request) {
            $item = CourseLessons::find($request->id);

            if ($item) {
                if ($item->learningStatus()->count()) {
                    CourseCurriculum::where(['itemable_id' => $item->id])->delete();
                    $item->status = 'inactive';
                    $item->save();
                    $message = __('Cannot_Delete_any_of_course_Items_as_Therere_Students_already_subscribed') . __('just de-activated');
                    $status = false;
                } else {
                    CourseCurriculum::where(['itemable_id' => $item->id])->delete();
                    $item->delete();
                    $message = __('delete_done');
                    $status = true;
                }
            } else {
                $message = __('message.item_not_found');
                $status = false;
            }

            return $this->response($message, $status);
        });
    }

    public function deleteCourseAttachment($request, $img_id): array
    {
        return $this->executeTransaction(function () use ($img_id, $request) {
            $item = LessonAttachment::find($img_id);

            if ($item) {
                $path = storage_path() . '/app/uploads/files/courses/' . $request->couse_id . '/lesson_attachments/' . $item->attachment;
                Storage::delete($path);
                $item->delete();
                $message = __('delete_done');
                $status = true;
            } else {
                $message = __('message.item_not_found');
                $status = false;
            }

            return $this->response($message, $status);
        });
    }
    public function getDuration($data, $request)
    {
        return $data['duration'] ?? $request->input('duration');
    }

    public function getAll($request, mixed $is_web): mixed
    {
        $data = $request->all();
        $user = $this->getUser($is_web);

        if (!$user) {
            $course          = Courses::whereId($data['course_id'])->select('id', 'user_id')->first();
            $data['user_id'] = $course->user_id;
        }
        else {
            $data['user_id'] = $user->id;
        }

        return $data;
    }
    public function handleAttachments($request, $data, $item)
    {
        if ($request->hasFile('files') && !empty($request->file('files'))) {
            foreach (@$request->file('files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(storage_path() . '/app/uploads/files/courses/' . $data['course_id'] . '/lesson_attachments', $filename);
                $item->attachments()->create([
                    'attachment' => $filename,
                    'lesson_type' => "live",
                ]);
            }
        }
    }
}
