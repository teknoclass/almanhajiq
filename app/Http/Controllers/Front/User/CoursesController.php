<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Repositories\Common\CourseCurriculumEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\CoursesEloquent;

class CoursesController extends Controller
{
    private $courses;
    private $course_curriculum;

    public function __construct(CoursesEloquent $courses_eloquent, CourseCurriculumEloquent $course_curriculum_eloquent)
    {
        $this->courses = $courses_eloquent;
        $this->course_curriculum = $course_curriculum_eloquent;
}


    public function myCourses(Request $request)
    {
        $data = $this->courses->myCourses($request, true, 9, false);

        if ($request->ajax()) {
            return View::make('front.user.courses.my_courses.partials.all', $data)->render();
        }

        return view('front.user.courses.my_courses.index', $data);
    }

    public function completedCourses(Request $request)
    {
        $data = $this->courses->completedCourses($request);

        if ($request->ajax()) {
            return View::make('front.user.courses.completed_courses.partials.all', $data)->render();
        }

        return view('front.user.courses.completed_courses.index', $data);
    }

    public function certificateIssuance($id)
    {
        return $this->courses->certificateIssuance($id);
    }
    public function joinLiveSession( Request $request){

        $url = $this->courses->joinLiveSession($request);

        return redirect($url);

    }
    public function curriculumItem($course_id, $curclm_item_id = null, $section_item_id = null)
    {

        $course = Courses::find($course_id);
        if($course){

            if($course->valid_on == 'app'){

                return redirect(url("courses/single/$course_id"));
            }
        }

        $data = $this->course_curriculum->curriculumItem($course_id, $curclm_item_id, $section_item_id);


        if ($data['type']==='live'){
            return view('front.user.courses.live', $data);
        }
        else{
            if ($data['error_message']) {
                return redirect()->back()->with('error', $data['error_message']);
            }
            return view('front.user.courses.curriculum.content', $data);
        }

    }

    public function openLearnPageByItemId($course_id, $type, $item_id)
    {
        $data = $this->course_curriculum->openLearnPageByItemId($course_id, $type, $item_id);

        return redirect()->route('user.courses.curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function navigation($type, $course_id, $curclm_item_id = null, $section_item_id = null)
    {
        $data = $this->course_curriculum->navigation($type, $course_id, $curclm_item_id, $section_item_id);

        return redirect()->route('user.courses.curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function setLessonAsCompleted($course_id, $id = null, $type = "normal")
    {
        $data = $this->course_curriculum->setLessonAsCompleted($course_id, $id, $type);

        return redirect()->back();
    }

    public function saveComment(Request $request, $course_id)
    {
        $response = $this->course_curriculum->saveComment($request, $course_id);

        return $this->response_api($response['status'], $response['message']);
    }

    public function register(Request $request)
    {
        $response = $this->courses->register($request);

        return $this->response_api($response['status'], $response['message'] , redirect_url:@$response['redirect_url']);
    }

    public function myActivity($id)
    {
        $data = $this->courses->myActivity($id);

        return view('front.user.courses.my_activity', $data);
    }


}
