<?php

namespace App\Services;

use App\Http\Requests\Panel\CourseRatingsRequest;
use App\Models\PrivateLessons;
use App\Models\PrivateLessonsRequest;
use App\Models\Ratings;
use App\Models\Transactios;
use App\Models\VisitorMessage;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PrivateLessonService
{

    public function storePostponeRequest($data)
    {
        try {
            $privateLessonRequest = PrivateLessonsRequest::firstOrCreate([
                'private_lesson_id'=>$data->private_lesson_id,
                'user_type'=>$data->user_type,
                'user_id' => auth()->id(),
            ]);
            $privateLessonRequest->update([
                'private_lesson_id' => $data->private_lesson_id,
                'user_id' => auth()->id(),
                'user_type' => $data->user_type,
                'type' => 'postpone',
                'suggested_dates' => $data->suggested_dates,
                'optional_files' => $this->uploadFiles($data->file('postpone_files'))??null,
            ]);
            $message = __("lesson postpone request sent");
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        } catch (\Exception $exception) {
            $message = __("can't postpone lesson date");
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            Log::error($exception->getMessage());
        }
        return $response;

    }
    public function storeCancelRequest($data)
    {
        try {
            $privateLessonRequest = PrivateLessonsRequest::firstOrCreate([
                'private_lesson_id'=>$data->private_lesson_id,
                'user_type'=>$data->user_type,
                'user_id' => auth()->id(),
            ]);

            $privateLessonRequest->update([
                'private_lesson_id' => $data->private_lesson_id,
                'user_id' => auth()->id(),
                'user_type' => $data->user_type,
                'type' => 'cancel',
                'status' => 'pending',
                'suggested_dates' => null,
                'optional_files' => $this->uploadFiles($data->file('postpone_files'))??null,

            ]);
            Log::alert($data->private_lesson_id);
            $message = __("lesson cancel request sent");
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        } catch (\Exception $exception) {
            $message =__( "can't cancel lesson date");
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            Log::error($exception->getMessage());
        }

        return $response;

    }
    protected function uploadFiles($files)
    {
        if (!$files) {
            return null;
        }

        $uploadedFiles = [];
        foreach ($files as $file) {
            $path = $file->store('supported_files', 'public');
            $uploadedFiles[] = $path;
        }
        return $uploadedFiles;
    }
    public function respondToRequest($data)
    {
        $data->chosen_date = $data->custom_date??$data->chosen_date;
        try {
            $lessonRequest = PrivateLessonsRequest::find($data->request_id);
            $lessonRequest->update([
                'status' => $data->status,
                'chosen_date' => $data->chosen_date?? null,
                'admin_response' => $data->admin_response??null,
            ]);

            if ($data->status == 'accepted') {
                if ($lessonRequest->type == 'postpone') {
                    $this->updatePrivateLessonDate($lessonRequest);
                } else {
                    $this->cancelPrivateLesson($lessonRequest);
                }
            }
            $message = __("lesson request updated");
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        } catch (\Exception $exception) {
            $message = __("can't update lesson request");
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            Log::error($exception->getMessage());
        }
        return $response;
    }

    protected function updatePrivateLessonDate(PrivateLessonsRequest $lessonRequest)
    {
        Log::alert($lessonRequest->privateLesson);
        $lessonRequest->privateLesson->update([
            'meeting_date' => $lessonRequest->chosen_date,
        ]);
    }

    protected function cancelPrivateLesson(PrivateLessonsRequest $lessonRequest)
    {
        $lessonRequest->privateLesson->update([
            'status' => 'canceled',
        ]);
        $price = $lessonRequest->privateLesson->price;
        Transactios::create([
            "user_id"=>auth()->id(),
            "user_type"=>"lecturer",
            "payment_id"=>0,
            "amount_before_discount"=>$price,
            "amount"=>$price,
            "type"=>"withdrow",
            "brand"=>"visa",
            "transactionable_id"=>$lessonRequest->privateLesson->id,
            "transactionable_type"=>"App\Models\PrivateLessons",
            "is_paid"=>1,
            "pay_transaction_id"=>0,
            "status"=>"completed",
            "description"=>"canceling a private lesson",
        ]);
    }

    public function adminRequest()
    {
        $data['requests'] = PrivateLessonsRequest::where('user_type', 'teacher')->with(['privateLesson', 'user'])->get();

        return $data;
    }
    public function teacherRequest()
    {
        $PrivateLessonsIds = PrivateLessons::where('teacher_id',auth()->id())->pluck('id');

        $data['requests'] = PrivateLessonsRequest::whereIn('private_lesson_id',$PrivateLessonsIds)->where('user_type','student')->with(['privateLesson','user'])->get();
        return $data;
    }
    public function getDataTable()
    {
        $data = PrivateLessonsRequest::select('users.name','private_lessons_requests.id','private_lessons_requests.status','private_lessons_requests.type','private_lessons_requests.optional_files','private_lessons_requests.admin_response','private_lessons_requests.suggested_dates',
            \DB::raw('DATE_FORMAT(private_lessons_requests.created_at, "%Y-%m-%d") as date'))->where('user_type','teacher')
            ->leftJoin('users', 'private_lessons_requests.user_id', '=', 'users.id')
            ->leftJoin('private_lessons', 'private_lessons_requests.private_lesson_id', '=', 'private_lessons.id')
                              ->orderByDesc('private_lessons_requests.created_at');
        $keyword = request()->get('search')['value'];
        if ($keyword) {
            $data->where(function($query) use ($keyword) {
                $query->where('private_lessons_requests.status', 'LIKE', "%{$keyword}%")
                      ->orWhere('private_lessons_requests.type', 'LIKE', "%{$keyword}%")
                      ->orWhere('users.name', 'LIKE', "%{$keyword}%")
                      ->orWhere(DB::raw('DATE_FORMAT(private_lessons_requests.created_at, "%Y-%m-%d ")'), 'LIKE', "%{$keyword}%");
            });
        }
        if ($order = request()->get('order')) {
            $columnIndex = $order[0]['column'];
            $direction   = $order[0]['dir'];
            $columns     = [
                'private_lessons_requests.id',
                'private_lessons_requests.status',
                'private_lessons_requests.type',
                'private_lessons_requests.admin_response',

            ];

            if (isset($columns[$columnIndex]) && $columns[$columnIndex] !== 'private_lessons_requests.id') {
                $data->orderBy($columns[$columnIndex], $direction);
            }
        }
        else {
            $data->orderByDesc('private_lessons_requests.created_at');
        }
        return Datatables::of($data)
                         ->addIndexColumn()

            ->addColumn('files', function ($row) {
                // Check if optional_files is an array or a JSON-encoded string
                $files = is_array($row->optional_files) ? $row->optional_files : json_decode($row->optional_files, true);

                $links = [];

                if (is_array($files)) {
                    foreach ($files as $file) {
                        $fileUrl = Storage::url($file); // Generate public URL for each file
                        $fileName = basename($file); // Extract file name for display
                        $links[] = "<a href='{$fileUrl}' download='{$fileName}'>{$fileName}</a>";
                    }
                }

                return implode('<br>', $links); // Join links with line breaks
            })

            ->addColumn('action', 'panel.private_lesson_requests.partials.actions')

                         ->rawColumns(['action', 'files'])
                         ->make(true);

    }

    public function edit($id)
    {
        $data['item'] = PrivateLessonsRequest::where('id', $id)->where('user_type','teacher')->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }


}
