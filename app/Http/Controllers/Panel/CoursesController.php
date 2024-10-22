<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CoursePriceDetailsRequest;
use App\Http\Requests\Panel\CoursesRequest;
use App\Models\Courses;
use App\Models\CourseSession;
use App\Repositories\Common\CourseCurriculumEloquent;
use App\Repositories\Panel\CoursesEloquent;
use Illuminate\Http\Request;
use App\Http\Resources\CoursesResources;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class CoursesController extends Controller
{
    //
    private $course_curriculum;
    private $courses;

    public function __construct(CoursesEloquent $courses_eloquent, CourseCurriculumEloquent $course_curriculum_eloquent)
    {
        $this->middleware('auth:admin');

        $this->course_curriculum = $course_curriculum_eloquent;
        $this->courses = $courses_eloquent;
    }

    public function index(Request $request)
    {
        return view('panel.courses.all');
    }

    public function getDataTable()
    {
        return $this->courses->getDataTable();
    }

    public function create()
    {
        $data = $this->courses->create();

        return view('panel.courses.create', $data);
    }

    public function store(CoursesRequest $request)
    {
        $response = $this->courses->store($request);

        return $this->response_api($response['status'], $response['message'] , null , @$response['redirect_url'] ?? null);
    }

    public function publish($id)
    {
        $response = $this->courses->publish($id);

        return $this->response_api($response['status'], $response['message'] ,$response['items'] , null , @$response['redirect_url'] ?? null);
    }

    public function edit($id)
    {

        $data = $this->courses->edit($id);


        return view('panel.courses.create', $data);
    }

    public function update($id, CoursesRequest $request)
    {
        $response = $this->courses->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->courses->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function deleteVideo($id)
    {
        $response = $this->courses->deleteVideo($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function editPriceDetails($id)
    {
        $data = $this->courses->editPriceDetails($id);


        return view('panel.courses.edit_price_details', $data);
    }

    public function updatePriceDetails($id, CoursePriceDetailsRequest $request)
    {
        $response = $this->courses->updatePriceDetails($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function editContentDetails($id,$type)
    {
        $data = $this->courses->editContentDetails($id,$type);


        return view('panel.courses.edit_content_details', $data);
    }

    public function updateContentDetails($id,$type,Request $request)
    {
        $response = $this->courses->updateContentDetails($id,$type, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function editCourseRequirements($id)
    {
        $data = $this->courses->editCourseRequirements($id);


        return view('panel.courses.edit_course_requirements', $data);
    }

    public function updatetCourseeRequirements($id, Request $request)
    {
        $response = $this->courses->updatetCourseeRequirements($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }



    public function editSections($id)
    {
        $data = $this->courses->editSections($id);


        return view('panel.courses.edit_sections', $data);
    }

    public function updateSections($id, Request $request)
    {
        $response = $this->courses->updateSections($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function editCourseFaqs($id)
    {
        $data = $this->courses->editCourseFaqs($id);


        return view('panel.courses.edit_course_faqs', $data);
    }

    public function updateCourseFaqs($id, Request $request)
    {
        $response = $this->courses->updateCourseFaqs($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function editWelcomeTextForRegistration($id)
    {
        $data = $this->courses->editWelcomeTextForRegistration($id);


        return view('panel.courses.edit_welcome_text_for_registration', $data);
    }

    public function updateWelcomeTextForRegistration($id, Request $request)
    {
        $response = $this->courses->updateWelcomeTextForRegistration($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function editForWhomThisCourse($id)
    {
        $data = $this->courses->editForWhomThisCourse($id);


        return view('panel.courses.edit_for_whom_this_course', $data);
    }

    public function updateForWhomThisCourse($id, Request $request)
    {
        $response = $this->courses->updateForWhomThisCourse($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function editSuggestedDates($id)
    {
        $data = $this->courses->editSuggestedDates($id);
        return view('panel.courses.edit_suggested_dates', $data);
    }

    public function editCourseSchedule($id)
    {
        $data = $this->courses->editCourseSchedule($id);
        $session = CourseSession::find(229);
        $data['session'] = $session;
        return view('panel.courses.edit_schedule', $data);
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
    public function saveGroupSessions(Request $request)
    {

        $response  = $this->courses->saveGroups($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function updateSuggestedDates($id, Request $request)
    {
        $response = $this->courses->updateSuggestedDates($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function editCurriculum($id)
    {
        $data = $this->courses->editCurriculum($id);

        return view('panel.courses.edit_curriculum', $data);
    }

    public function curriculumItem($course_id, $curclm_item_id = null, $section_item_id = null)
    {
        $data = $this->course_curriculum->curriculumItem($course_id, $curclm_item_id, $section_item_id);

        return view('front.user.lecturer.courses.preview_curriculum.content', $data);
    }

    public function openLearnPageByItemId($course_id, $type, $item_id)
    {
        $data = $this->course_curriculum->openLearnPageByItemId($course_id, $type, $item_id);

        return redirect()->route('panel.courses.preview_curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function navigation($type, $course_id, $curclm_item_id = null, $section_item_id = null)
    {
        $data = $this->course_curriculum->navigation($type, $course_id, $curclm_item_id, $section_item_id);

        return redirect()->route('panel.courses.preview_curriculum.item', ['course_id' => @$data['course_id'], 'curclm_item_id' => @$data['target_curclm_item_id'], 'section_item_id' => @$data['target_section_item_id']]);
    }

    public function previewCourse($course_id)
    {
        $data = $this->course_curriculum->previewCourse($course_id);

        return view('front.courses.single', $data);
    }

    public function search($type, Request $request)
    {

        return $this->courses->search($type, $request);

    }

   public function getLecturers(Request $request)
   {

       $items= $this->courses->getLecturers($request);

       if($items!='') {
           return response()->json(['status' => true  ,'options'=>$items]);
       } else {
           return response()->json(['status' => false  ]);
       }

   }

public function getLevels(Request $request)
{

    $items= $this->courses->getLevels($request);

    if($items!='') {
        return response()->json(['status' => true  ,'options'=>$items]);
    } else {
        return response()->json(['status' => false  ]);
    }

}




}
