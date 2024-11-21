<?php

namespace App\Services;

use App\Models\CourseSession;
use App\Models\CourseSessionsRequest;
use App\Models\Transactios;
use App\Models\UserCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use Yajra\DataTables\DataTables;

class CourseSessionService
{
    #[ArrayShape(['message' => "mixed", 'status' => "bool"])]
    public function storePostponeRequest($data): array
    {
        try {
            $courseSessionRequest= CourseSessionsRequest::firstOrCreate([
                'course_session_id'=>$data->course_session_id,
                'user_type'=>$data->user_type,
                'user_id' => auth()->id(),
            ]);
            $courseSessionRequest->update([
                'course_session_id' => $data->course_session_id,
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

            if($data->user_type == "teacher")
            {
                sendNotifications('  طلب تاجيل جلسة',' طلب تاجيل مدرس لجلسة ','course_session_request',$courseSessionRequest->id,'show_courses','admin');
            }else{
                $userId = $courseSessionRequest->courseSession->course->user_id;
                sendNotification(' طلب تاجيل جلسة',' طلب تاجيل طالب لجلسة  ',
                $userId,'user', 'course_session_request',
                $courseSessionRequest->id);
            }

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
            $courseSessionRequest = CourseSessionsRequest::firstOrCreate([
                'course_session_id'=>$data->course_session_id,
                'user_type'=>$data->user_type,
                'user_id' => auth()->id(),
            ]);

            $courseSessionRequest->update([
                'course_session_id' => $data->course_session_id,
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

            if($data->user_type == "teacher")
            {
                sendNotifications(' طلب الغاء جلسة',' طلب الغاء مدرس لجلسة ','course_session_request',$courseSessionRequest->id,'show_courses','admin');
            }else{
                $userId = $courseSessionRequest->courseSession->course->user_id;
                sendNotification(' طلب تاجيل جلسة',' طلب الغاء طالب لجلسة  ',
                $userId,'user', 'course_session_request',
                $courseSessionRequest->id);
            }
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
            $lessonRequest = CourseSessionsRequest::find($data->request_id);
            $lessonRequest->update([
                'status' => $data->status,
                'chosen_date' => $data->chosen_date?? null,
                'admin_response' => $data->admin_response??null,
            ]);

            $course_session_id = $lessonRequest->course_session_id;

            if ($data->status == 'accepted') {
                if ($lessonRequest->type == 'postpone') {
                    $this->updateLessonDate($lessonRequest);

                    //to lecturer
                    sendNotification('قبول طلب التاجيل',' تم الموافقة على طلب تاجيلك للجلسة  '.'( '. @CourseSession::find($course_session_id)->title .' )',
                    $lessonRequest->user_id,'user', 'course_session_request',
                    $lessonRequest->id);

                    //to students
                    $course_id = @CourseSession::find($course_session_id)->course_id;
                    $userIds = @UserCourse::where('course_id',$course_id)->pluck('user_id')->toArray();

                    sendNotifications('قبول طلب التاجيل',   'تم الموافقة على طلب تأجيل المحاضر للجلسة '.' (' . @CourseSession::find($course_session_id)->title . ')'.'إلى يوم ' . @CourseSession::find($course_session_id)->date ,'curriculum.item',
                    $course_id,null,"user",$userIds);
                    
                } else {
                    $this->cancelLesson($lessonRequest);

                    //to lecturer
                    sendNotification('قبول طلب الغاء الجلسة',' تم الموافقة على طلب الغاءك للجلسة  '.'( '. @CourseSession::find($course_session_id)->title .' )',
                    $lessonRequest->user_id,'user', 'course_session_request',
                    $lessonRequest->id);

                    //to students
                    $course_id = @CourseSession::find($course_session_id)->course_id;
                    $userIds = @UserCourse::where('course_id',$course_id)->pluck('user_id')->toArray();

                    sendNotifications('قبول طلب الغاء الجلسة',' تم الموافقة على طلب الغاء المحاضر للجلسة  '.'( '. @CourseSession::find($course_session_id)->title .' )','course_session_request',
                    $lessonRequest->id,null,"user",$userIds);
                }
            }else{
                if ($lessonRequest->type == 'postpone') {
                  
                    sendNotification('رفض طلب التاجيل الجلسة',' تم رفض طلب تاجيلك للجلسة  '.'( '. @CourseSession::find($course_session_id)->title .' )',
                    $lessonRequest->user_id,'user', 'course_session_request',
                    $lessonRequest->id);
                } else {
                    sendNotification('رفض طلب الغاء الجلسة','تم رفض طلب الغاءك للجلسة  '.'( '. @CourseSession::find($course_session_id)->title .' )',
                    $lessonRequest->user_id,'user', 'course_session_request',
                    $lessonRequest->id);
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

    protected function updateLessonDate(CourseSessionsRequest $lessonRequest)
    {
        Log::alert($lessonRequest->courseSession);
        $lessonRequest->courseSession->update([
            'date' => $lessonRequest->chosen_date,
        ]);
    }

    protected function cancelLesson(CourseSessionsRequest $lessonRequest)
    {
        $lessonRequest->courseSession->update([
            'status' => 'canceled',
        ]);
//        $price = $lessonRequest->privateLesson->price;
//        Transactios::create([
//            "user_id"=>auth()->id(),
//            "user_type"=>"lecturer",
//            "payment_id"=>0,
//            "amount_before_discount"=>$price,
//            "amount"=>$price,
//            "type"=>"withdrow",
//            "brand"=>"visa",
//            "transactionable_id"=>$lessonRequest->privateLesson->id,
//            "transactionable_type"=>"App\Models\PrivateLessons",
//            "is_paid"=>1,
//            "pay_transaction_id"=>0,
//            "status"=>"completed",
//            "description"=>"canceling a private lesson",
//        ]);
    }

    public function adminRequest()
    {
        $data['requests'] = CourseSessionsRequest::where('user_type', 'teacher')->with(['courseSession', 'user'])->get();

        return $data;
    }
    public function teacherRequest()
    {
        $courseLessonsIds = CourseSession::whereHas('course', function ($query) {
            $query->where('user_id', auth()->id());
        })->pluck('id');

        $data['requests'] = CourseSessionsRequest::whereIn('course_session_id',$courseLessonsIds)->where('user_type','student')->with(['CourseSession','user'])->get();
        return $data;
    }
    public function getDataTable()
    {
        $data = CourseSessionsRequest::select('courses_translations.title as course_title','users.name as user','course_sessions_requests.id','course_sessions_requests.status','course_sessions_requests.type','course_sessions_requests.optional_files','course_sessions_requests.admin_response','course_sessions_requests.suggested_dates',
            \DB::raw('DATE_FORMAT(course_sessions_requests.created_at, "%Y-%m-%d") as date'))->where('user_type','teacher')
                                     ->leftJoin('users', 'course_sessions_requests.user_id', '=', 'users.id')
                                     ->leftJoin('course_sessions', 'course_sessions_requests.course_session_id', '=', 'course_sessions.id')
                                     ->leftJoin('courses', 'course_sessions.course_id', '=', 'courses.id')
                                     ->leftJoin('courses_translations', 'courses_translations.courses_id', '=', 'courses.id')
                                     ->orderByDesc('course_sessions_requests.created_at')

        ;
        $keyword = request()->get('search')['value'];
        if ($keyword) {
            $data->where(function($query) use ($keyword) {
                $query->where('course_sessions_requests.status', 'LIKE', "%{$keyword}%")
                      ->orWhere('course_sessions_requests.type', 'LIKE', "%{$keyword}%")
                      ->orWhere('users.name', 'LIKE', "%{$keyword}%")
                      ->orWhere(DB::raw('DATE_FORMAT(course_sessions_requests.created_at, "%Y-%m-%d ")'), 'LIKE', "%{$keyword}%");
            });
        }
        if ($order = request()->get('order')) {
            $columnIndex = $order[0]['column'];
            $direction   = $order[0]['dir'];
            $columns     = [
                'course_sessions_requests.id',
                'course_sessions_requests.status',
                'course_sessions_requests.type',
                'course_sessions_requests.admin_response',

            ];

            if (isset($columns[$columnIndex]) && $columns[$columnIndex] !== 'course_sessions_requests.id') {
                $data->orderBy($columns[$columnIndex], $direction);
            }
        }
        else {
            $data->orderByDesc('course_sessions_requests.created_at');
        }
        $data->distinct('id');

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
                         ->editColumn('status',function($row){
                            return __($row->status);
                         })
                         ->editColumn('type',function($row){
                            return __($row->type);
                         })
                         ->addColumn('action', 'panel.courses.partials.course_sessions.partials.actions')

                         ->rawColumns(['action', 'files'])
                         ->make(true);

    }

    public function edit($id)
    {
        $data['item'] = CourseSessionsRequest::where('id', $id)->where('user_type','teacher')->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }
}
