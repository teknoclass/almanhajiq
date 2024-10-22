<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\CourseComments;
use App\Models\Courses;
use App\Models\JoinAsTeacherRequests;
use App\Models\PrivateLessons;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['teachers_count']=User::where('role',User::LECTURER)->count();
        $data['students_count']=User::where('role',User::STUDENTS)->count();
        $data['courses_count']=Courses::count();
        $data['lessons_count']=PrivateLessons::count();
        $data['course_comments_count']=CourseComments::count();
        ///////////////////////
        $data['last_courses']=Courses::orderBy('id', 'desc')->take(5)->get();
        $data['last_comments']=CourseComments::orderBy('id', 'desc')->take(5)->get();
        $data['last_lessons']=PrivateLessons::orderBy('id', 'desc')->take(5)->get();
        $data['last_join_as_teacher_requests']=JoinAsTeacherRequests::orderBy('id', 'desc')->take(5)->get();
        $data['student_courses']=User::where('role',User::STUDENTS)->withCount('courses')->orderBy('courses_count', 'desc')->take(5)->get();
        $data['top_courses']=Courses::withCount('students')->orderBy('students_count', 'desc')->take(5)->get();
        return view('panel.home',$data);
    }
}
