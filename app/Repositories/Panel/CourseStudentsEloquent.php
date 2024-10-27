<?php

namespace App\Repositories\Panel;


use App\Models\Courses;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class CourseStudentsEloquent
{
    private $courses;
    public function __construct(CoursesEloquent $courses_eloquent)
    {

        $this->courses = $courses_eloquent;
    }

    public function getDataTable()
    {
        $data = UserCourse::orderByDesc('created_at')
        ->select(
            '*',
            \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date')
        )
        ->with('user:id,name')
        ->with([
            'course' => function ($query) {
                $query->select('id','user_id')
                    ->with('translations:courses_id,title,locale');
            }
        ])->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.course_students.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function operation($request)
    {
        $id        = $request->get('id');
        $operation = $request->get('operation');

        $item = UserCourse::find($id);
        if ($item) {
            if ($operation == 'is_complete_payment') {
                $item->is_complete_payment = !$item->is_complete_payment;
                $item->update();
            }

            $message  = __('message_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $message  = __('message_error');
        $status   = false;
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function getDataTableCourse($course_id)
    {
        $data = UserCourse::orderByDesc('created_at')
            ->select(
                '*',
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date')
            )
            ->where('course_id',$course_id)
            ->with('user:id,name')
            ->with([
                'course' => function ($query) {
                    $query->select('id','user_id')
                        ->with('translations:courses_id,title,locale');
                }
            ])->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);

    }

    public function store($request)
    {

        DB::beginTransaction();

          try {
              $ch = UserCourse::where('course_id', $request->get('course_id'))
                  ->where('user_id', $request->get('user_id'))
                  ->count();

              if ($ch == 0) {
                  $data = $request->all();
                  // $data['is_complete_payment']=1;
                  $data['register_sourse'] = UserCourse::REGISTER_FROM_ADMIN;
                  $data['register_by'] = Auth::user()->id;


                  //

                  $course_id = $request->get('course_id');

                  $user_course = UserCourse::create($data);


                  DB::commit();

                  $message = __('message_done');
                  $status = true;

                  $response = [
                      'message' => $message,
                      'status' => $status,
                  ];

                  return $response;


              }
              else{

                  $status = false;
                  $message = __('message.add_student_error');
              }
          }
          catch
              (\Exception $e) {
                  DB::rollback();

                  $status = false;
                  $message = __('message.unexpected_error');
              }

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;


    }

    public function getCourseInfo($request)
    {

        $lecturers=$this->courses->getLecturers($request);

        $levels=$this->courses->getLevels($request);

        $course=Courses::find($request->course_id);


        $weekly_meeting_times=View::make(
            'panel.course_students.partials.weekly_meeting_times',
            [
            'course'=>$course
         ]
        )->render();

        return [
            'status'=>true,
            'message'=>'',
            'items'=>[
                'lecturers'=>$lecturers,
                'levels'=>$levels,
                'weekly_meeting_times'=>$weekly_meeting_times
            ]
        ];

    }

    public function delete($id)
    {
        $item=UserCourse::find($id);

        if ($item) {
            $item->delete();
            $message = 'تم الحذف بنجاح  ';
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $message = 'حدث خطأ غير متوقع';
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


}
