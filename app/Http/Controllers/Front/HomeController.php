<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\HomeEloquent;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Courses;

class HomeController extends Controller
{
    protected $home;
    public function __construct(HomeEloquent $home_eloquent)
    {
        $this->home = $home_eloquent;
    }
    public function index()
    {
        $data = $this->home->index();

        return view('front.home.index', $data);
    }

    public function teachers()
    {
        return view('front.lecturers.index');
    }

    public function testCourses()
    {
        return view('front.courses.test_courses');
    }

    public function liveCourse()
    {
        return view('front.courses.backup.live');
    }

    public function textCourse()
    {
        return view('front.courses.backup.text');
    }

    public function singleCourse()
    {
        return view('front.courses.single');
    }

    public function turkishCurriculumIndex()
    {
        return view('front.turkish_curriculum.index');
    }

    public function turkishCurriculumSingle()
    {
        return view('front.turkish_curriculum.single');
    }

    public function forumIndex()
    {
        return view('front.forum.index');
    }

    public function catForum()
    {
        return view('front.forum.index-cat');
    }

    public function ForumSingle()
    {
        return view('front.forum.single');
    }

    public function showQuizResult($result_token)
    {
        $data = $this->home->showQuizResult($result_token);

        return view('front.show_result.quiz_result',$data);
    }

    public function showAssignmentResult($result_token)
    {
        $data = $this->home->showAssignmentResult($result_token);

        return view('front.show_result.assignment_result',$data);
    }

    public function getSubjects($gradeLevelId)
    {
        $subjects = Category::where('parent', 'grade_levels')->where('parent_id',$gradeLevelId)->get();

        return response()->json($subjects);
    }

    public function getTopics($year)
    {
        $topics = Courses::where('grade_sub_level', $year)->get();

        return response()->json($topics);
    }
}
