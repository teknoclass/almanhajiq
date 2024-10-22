<?php

namespace App\Http\Controllers\Front\User\Lecturer;

use App\Http\Requests\Front\User\Lecturer\Courses\AddPrice;
use App\Models\User;
use App\Models\Courses;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CourseSections;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\HomeUserEloquent;
use App\Http\Requests\Front\User\Lecturer\Courses\AddQuiz;
use App\Http\Requests\Front\User\Lecturer\Courses\AddTask;
use App\Http\Requests\Front\User\Lecturer\Courses\AddCourse;
use App\Http\Requests\Front\User\Lecturer\Courses\AddLesson;
use App\Http\Requests\Front\User\Lecturer\Courses\AddLiveLesson;
use App\Repositories\Front\User\Lecturer\LecturerHomeEloquent;
use App\Http\Requests\Front\User\Lecturer\Courses\AddSectionRequest;
use App\Repositories\Common\CurriculumCreationEloquent;

class HomeController extends Controller
{
    //
    private $home_user;
    private $lecturer_home;
    public function __construct(
        HomeUserEloquent $home_user_eloquent,
        LecturerHomeEloquent $lecturer_home_eloquent,
    ) {
        $this->home_user        = $home_user_eloquent;
        $this->lecturer_home    = $lecturer_home_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->home_user->index($request, User::LECTURER);

        return view('front.user.home_user.lecturer', $data);

    }

    public function ratings(Request $request)
    {
        $data = $this->lecturer_home->viewRatings();

        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.ratings.partials.all', $data)->render();
        }

        return view('front.user.lecturer.courses.ratings.index', $data);

    }

    public function students(Request $request)
    {
        $data = $this->lecturer_home->viewStudents();

        if ($request->ajax()) {
            return View::make('front.user.lecturer.students.partials.all', $data)->render();
        }

        return view('front.user.lecturer.students.index', $data);
    }

    public function studentsFilter(Request $request)
    {
        $data = $this->lecturer_home->filterStudents($request);

        return view('front.user.lecturer.students.index', $data);
    }

    public function studentCourses($id, Request $request)
    {
        $data = $this->lecturer_home->studentCourses($id);

        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.partials.all-courses', $data)->render();
        }

        return view('front.user.lecturer.students.partials.courses', $data);
    }

    public function studentLessons($id, Request $request)
    {
        $data = $this->lecturer_home->studentLessons($id);

        if ($request->ajax()) {
            return View::make('front.user.lecturer.private_lessons.partials.all', $data)->render();
        }

        return view('front.user.lecturer.students.partials.lessons', $data);
    }


    /* courses functions */

    public function createCourse($active_tab = 'settings')
    {
        $data               = $this->lecturer_home->createCourse();
        $data['active_tab'] = $active_tab;
        $user_id            = auth('web')->user()->id;
        if($active_tab != 'settings') {
            $data['course'] = Courses::where('user_id' ,  $user_id)->select('id')->orderBy('id' , 'DESC')->first();
        }
        if($active_tab == 'curriculum') {
            if( $data['course']) {
                $data['course_sections'] = CourseSections::where('course_id' , $data['course']->id)->get();
            }else {
                $data['course_sections'] = [];
            }
        }

        return view('front.user.lecturer.courses.new_course.index', $data);
    }


    public function AddCourse(AddCourse $request) {
      //  dd($request->all());
        $data = $this->lecturer_home->addCourse($request);
        return response()->json($data);
    }



    // public function myCourses(Request $request)
    // {
    //     return view('front.user.lecturer.courses.my_courses.my_courses');
    // }


    // public function myCoursesratings()
    // {
    //     return view('front.user.lecturer.courses.my_courses.ratings');
    // }

    // public function studentActivity()
    // {
    //     return view('front.user.lecturer.courses.my_courses.student_activity');
    // }

    // public function certificates()
    // {
    //     return view('front.user.lecturer.courses.my_courses.certificates');
    // }

    // public function addPrice(AddPrice $request) {
    //      $data = $this->lecturer_home->addPrice($request);
    //      return response()->json($data);
    // }

    // public function addFaq(Request $request) {
    //     $data = $this->lecturer_home->addFaq($request);
    //     return response()->json($data);
    // }

    /* end courses functions */

}
