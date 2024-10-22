<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\{CourseSession,Courses,CourseSessionInstallment};
use App\Repositories\Panel\HomePageSectionsEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallmentsSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index($course_id)
    {
        $data['item'] = Courses::find($course_id);
        $data['installments'] = CourseSessionInstallment::where('course_id', $course_id)->get();
        // $takedLessons = CourseSessionInstallment::where("course_id",$course_id)->pluck('course_session_id')->toArray();
        $data['lessons'] = CourseSession::where("course_id",$course_id)
        // ->whereNotIn("id",$takedLessons)
        ->get();
        
        return view('panel.installments_settings.index',$data);
    }

    public function getLessons($course_id)
    {
        // $takedLessons = CourseSessionInstallment::where("course_id",$course_id)->pluck('course_session_id')->toArray();

        return CourseSession::where("course_id",$course_id)
        // ->whereNotIn("id",$takedLessons)
        ->get();
    }

    public function store(Request $request)
    {
        $course_id = $request->course_id;

        if(empty($request->installments))
        {
            CourseSessionInstallment::where('course_id', $course_id)->delete();
        
            return response()->json(["status" => "success",'message' => __('done_operation')]);
        }

        DB::transaction(function () use ($request, $course_id) {
            CourseSessionInstallment::where('course_id', $course_id)->delete();
            $installments = $request->installments;
            foreach ($installments as $installment) {
                CourseSessionInstallment::create([
                    'name' => $installment['name'],
                    'price' => $installment['price'],
                    'course_id' => $course_id,
                    'course_session_id' => $installment['lesson_id'],
                ]);
            }
        });

        return response()->json(["status" => "success",'message' => __('done_operation')]);
    }
}