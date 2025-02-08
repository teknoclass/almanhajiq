<?php

namespace App\Http\Controllers\Front\User\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\CourseSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Front\User\Lecturer\CoursesEloquent;
use App\Http\Requests\Front\User\Lecturer\Courses\AddCourse;
use App\Http\Requests\Front\User\Lecturer\Courses\CoursePriceDetailsRequest;
use App\Models\CourseAssignments;
use App\Models\Courses;
use App\Models\CourseLessons;
use App\Models\CourseLiveLesson;
use App\Models\CourseQuizzes;
use App\Models\User;
use App\Repositories\Common\CourseCurriculumEloquent;

class CoursesController extends Controller
{
    private $courses;
    private $course_curriculum;

    public function __construct(CoursesEloquent $courses_eloquent, CourseCurriculumEloquent $course_curriculum_eloquent)
    {
        $this->courses = $courses_eloquent;
        $this->course_curriculum = $course_curriculum_eloquent;
    }
    public function publish($id)
    {
        $response = $this->courses->publish($id);

        return $this->response_api($response['status'], $response['message'] ,$response['items'] , null , @$response['redirect_url'] ?? null);
    }
    public function index()
    {
        return view('front.user.home_user.lecturer');
    }

    public function myCourses(Request $request)
    {
        $data = $this->courses->myCourses($request);
        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.partials.all-courses', $data)->render();
        }
        return view('front.user.lecturer.courses.my_courses.my_courses', $data);
    }

    public function myLiveLessons(Request $request)
    {
        $data = $this->courses->myLiveLessons();

        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.live_lessons.partials.all', $data)->render();
        }

        return view('front.user.lecturer.courses.my_courses.live_lessons.index', $data);
    }

    public function create()
    {
        $data = $this->courses->create();
        return view('front.user.lecturer.courses.my_courses.create.create', $data);
    }

    public function store(AddCourse $request)
    {
        //  dd($request->all());
        $data = $this->courses->addCourse($request);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = $this->courses->edit($id);
        return view('front.user.lecturer.courses.my_courses.create.create', $data);
    }

    public function update($id, AddCourse $request)
    {
        $data = $this->courses->update($id, $request);
        return response()->json($data);
    }

    public function editWelcomeTextForRegistration($id)
    {
        $data = $this->courses->editWelcomeTextForRegistration($id);
        return view('front.user.lecturer.courses.my_courses.create.edit_welcome_text_for_registration', $data);
    }
    public function editSuggestedDates($id)
    {
        $data = $this->courses->editSuggestedDates($id);
        return view('front.user.lecturer.courses.my_courses.create.edit_suggested_dates', $data);
    }

    public function editCourseSchedule($id)
    {
        $data = $this->courses->editCourseSchedule($id);
        $session = CourseSession::find($id);

        $data['session'] = $session;
        return view('front.user.lecturer.courses.my_courses.create.edit_schedule', $data);
    }
    public function previewCourseSchedule($id)
    {
        $data = $this->courses->editCourseSchedule($id);
        $session = CourseSession::find($id);

        $data['session'] = $session;
        return view('front.user.lecturer.courses.my_courses.partials.course_schedule_preview', $data);
    }

    public function createLiveSession($id){
        /** @var CourseSession $session***/
        $url = $this->courses->createLiveSession($id);
        return redirect($url);

    }

    public function updateCourseSchedule($id,Request $request)
    {

        $response = $this->courses->updateCourseSchedule($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }
    public function updateSuggestedDates($id, Request $request)
    {
        $response = $this->courses->updateSuggestedDates($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function updateWelcomeTextForRegistration($id, Request $request)
    {
        $data = $this->courses->updateWelcomeTextForRegistration($id, $request);
        return response()->json($data);
    }

    public function editPriceDetails($id)
    {
        $data = $this->courses->editPriceDetails($id);
        return view('front.user.lecturer.courses.my_courses.create.edit_price_details', $data);
    }

    public function updatePriceDetails($id, CoursePriceDetailsRequest $request)
    {
        $data = $this->courses->updatePriceDetails($id, $request);
        return response()->json($data);
    }

    public function editContentDetails($id, $type)
    {
        $data = $this->courses->editContentDetails($id, $type);
        return view('front.user.lecturer.courses.my_courses.create.edit_content_details', $data);
    }

    public function updateContentDetails($id, $type, Request $request)
    {
        $data = $this->courses->updateContentDetails($id, $type, $request);
        return response()->json($data);
    }

    public function editCourseFaqs($id)
    {
        $data = $this->courses->editCourseFaqs($id);
        return view('front.user.lecturer.courses.my_courses.create.edit_course_faqs', $data);
    }

    public function updateCourseFaqs($id, Request $request)
    {
        $data = $this->courses->updateCourseFaqs($id, $request);
        return response()->json($data);
    }

    public function editCourseRequirements($id)
    {
        $data = $this->courses->editCourseRequirements($id);
        return view('front.user.lecturer.courses.my_courses.create.edit_course_requirements', $data);
    }

    public function updatetCourseeRequirements($id, Request $request)
    {
        $data = $this->courses->updatetCourseeRequirements($id, $request);
        return response()->json($data);
    }

    public function updateRequestReview($id, Request $request)
    {
        $data = $this->courses->updateRequestReview($id, $request);

        return response()->json($data);
    }


    // end show modal

    // public function requestReview()
    // {
    //     $data = $this->courses->requestReview();

    //     return view('front.user.lecturer.courses.details.recorded.request_review', $data);
    // }

    public function courseCurriculum($id)
    {
        $data = $this->courses->courseCurriculum($id);
        return view('front.user.lecturer.courses.my_courses.create.curriculum', $data);
    }

    public function waitingEvaluation($id)
    {
        $data = $this->courses->waitingEvaluation($id);

        return view('front.user.lecturer.courses.my_courses.create.evaluation_waiting', $data);
    }

    public function unacceptedEvaluation($id)
    {
        $data = $this->courses->unacceptedEvaluation($id);

        return view('front.user.lecturer.courses.my_courses.create.evaluation_unaccepted', $data);
    }

    public function courseTasks() {
        $data = $this->courses->courseTasks();
        return view('front.user.lecturer.courses.details.recorded.tasks', $data);
    }

    public function tasks(Request $request, $id) {

         $data = $this->courses->tasks($id);

        if ($request->ajax()) {
             return View::make('front.user.lecturer.courses.my_courses.tasks.partials.all', $data)->render();
        }
        return view('front.user.lecturer.courses.my_courses.tasks.all', $data);
    }

    // get student tasks

    public function task_students(Request $request, $course_id)
    {
        $data  = $this->courses->task_students($course_id);
        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.tasks.partials.student_tasks', $data)->render();
       }
        return view('front.user.lecturer.courses.my_courses.tasks.students', $data);
    }

    public function exams(Request $request, $id) {

        $data = $this->courses->exams($id);

       if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.exams.partials.all', $data)->render();
       }
       return view('front.user.lecturer.courses.my_courses.exams.all', $data);
   }

   // get student tasks

   public function exam_students(Request $request, $course_id)
   {
       $data  = $this->courses->exam_students($course_id);
        if ($request->ajax()) {
           return View::make('front.user.lecturer.courses.my_courses.exams.partials.student_exams', $data)->render();
        }
       return view('front.user.lecturer.courses.my_courses.exams.students', $data);
    }

    public function viewRatings($id, Request $request)
    {
        $data = $this->courses->viewRatings($id);
        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.partials.reviews.all', $data)->render();
        }
        return view('front.user.lecturer.courses.my_courses.details.ratings.index', $data);
    }

    public function correctTask(Request $request)
    {
        $data = $this->courses->correctTask($request);
        return response()->json($data);
    }

    public function comments($id, Request $request)
    {
        $data = $this->courses->comments($id);
        if ($request->ajax()) {
            return View::make('front.user.lecturer.courses.my_courses.comments.partials.comment', $data)->render();
        }
        return view('front.user.lecturer.courses.my_courses.comments.all', $data);
    }

    public function deleteComment($id)
    {
        $data = $this->courses->delete_comment($id);
        return response()->json($data);
    }

    public function publish_comment(Request $request) {
        $data = $this->courses->publish_comment($request);
        return response()->json($data);
    }


    public function curriculumItem($course_id, $curclm_item_id = null, $section_item_id = null)
    {
        $data = $this->course_curriculum->curriculumItem($course_id, $curclm_item_id, $section_item_id);
        // dd($data);
        return view('front.user.lecturer.courses.preview_curriculum.content', $data);
    }

    public function openLearnPageByItemId($course_id, $type, $item_id)
    {
        $data = $this->course_curriculum->openLearnPageByItemId($course_id, $type, $item_id);

        return redirect()->route('user.lecturer.course.curriculum.preview_curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function navigation($type, $course_id, $curclm_item_id = null, $section_item_id = null)
    {
        $data = $this->course_curriculum->navigation($type, $course_id, $curclm_item_id, $section_item_id);

        return redirect()->route('user.lecturer.course.curriculum.preview_curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function previewCourse($course_id)
    {
        $data = $this->course_curriculum->previewCourse($course_id);

        return view('front.courses.single', $data);
    }

    public function deleteCourse(Request $request)
    {
        $data = $this->courses->deleteCourse($request);

        return response()->json($data);
    }

    public function createMeeting($id)
    {
        $data = $this->course_curriculum->startLiveLesson($id);

        if(!$data['status']){
            return back()->withInput();
        }

        return view('front.user.meeting.show_meeting', $data);
    }

    public function joinMeeting($id)
    {
        $data = $this->course_curriculum->joinLiveLesson($id);

        if(!$data['status']){
            return back()->withInput();
        }

        return view('front.user.meeting.show_meeting', $data);
    }

    public function setMeetingFinished($id)
    {
        $data = $this->course_curriculum->setMeetingFinished($id);

        return view('front.components.meeting_finished');
    }

    public function showRecording($id)
    {
        $data = $this->course_curriculum->showRecording($id);

        return view('front.user.meeting.show_meeting', $data);
    }

    public function updateSessionPrice(Request $request)
    {
        $item = CourseSession::find($request->id);
        if($item)
        {
             $item->price = $request->price;
             $item->save();
             return  $response = [
                 'status_msg' => 'success',
                 'message' => __('done_operation'),
             ];
        }else{
             return  $response = [
                 'status_msg' => 'error',
                 'message' => __('session_not_found'),
             ];
        }
    }
    function submitMark(Request $request)
    {
        $data = $this->courses->submitMark($request,true);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }

    function submitResult(Request $request){
        $data = $this->courses->submitResult($request,true);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }


}
