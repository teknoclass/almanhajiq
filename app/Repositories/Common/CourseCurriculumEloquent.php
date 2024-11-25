<?php

namespace App\Repositories\Common;

use App\Http\Resources\ApiCurriculumAssignmentResource;
use App\Http\Resources\ApiCurriculumLessonResource;
use App\Http\Resources\ApiCurriculumQuizResource;
use App\Models\CourseSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Courses;
use App\Models\CourseAssignments;
use App\Models\CourseComments;
use App\Models\CourseCurriculum;
use App\Models\CourseLessons;
use App\Models\CourseLessonsLearning;
use App\Models\CourseLiveLesson;
use App\Models\CourseQuizzes;
use App\Models\CourseSectionItems;
use App\Models\Notifications;
use App\Models\UserCourse;
use App\Repositories\Front\User\HelperEloquent;
use BigBlueButton\Parameters\GetRecordingsParameters;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPUnit\TextUI\Configuration\Constant;

class CourseCurriculumEloquent extends HelperEloquent
{

    public function curriculumItem($course_id, $curclm_item_id, $section_item_id, $is_web = true)
    {

//        $data['sessions'] = CourseSession::where('course_id',$course_id)->get();

        $data['user'] = $this->getUser($is_web);

        // Check if the course exist and the user is subscribed to it

        $course =$this->getCourse($course_id);
        $data['course'] =$course;
        $data['type'] =$course->type;

        if ($data['course'] =='') {
            abort(404);
        }


        $data['sessions'] = CourseSession::where('course_id',$course_id)->get();

        // Get the navigation widget items
        $data['curriculum_items'] = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $course_id)
                                                    ->with('section.items', function ($query) {
                                                        $query->with('itemable')->activeStatusBasedOnUser();
                                                    })->order('asc')->get();


        // Get the item that will be opened in the Learning page (for opening certain item, open curriculum for the first time ...)
        $selected_item = $this->getCurSectionItem($course_id, $curclm_item_id, $section_item_id);

        $data['error_message'] = @$selected_item['error_message'];
        $type                  = 'Pending';
        $item_id               = null;
        if ($selected_item) {
            // Get the item and its type (lesson, quiz, assignment)
            $item_id = $selected_item['c_item']->itemable_id;
            $type = $selected_item['c_item']->itemable_type;

            // If the item is inside section identify the selected relations with curriculum and section_items tables
            if (@$selected_item['curclm_item_id']){
                $data['selected_curriculum_item_id'] = $selected_item['curclm_item_id'];
                $data['selected_curriculum_section_id'] = $selected_item['c_item']->id;
            }
            // If the item isn't inside section identify the selected relations with curriculum table
            else {
                $data['selected_curriculum_item_id'] = $selected_item['c_item']->id;
            }
        }
        // else abort(404);

        $data['item_type'] = config('constants.item_model_types.'.$type);

        // Get the (lesson / quiz / assignment) itself and merge it with $data
        $itemData = $this->getCourseItem(config('constants.item_model_types.'.$type), $item_id);

        $data = array_merge($data, $itemData);

        $data['is_course_finished'] = 0;

        if (count($data['curriculum_items'])>0){
            if($data['curriculum_items']->sortByDesc('order')->first()->id == $data['course']->last_item->id && isset($data['user'])){
                $data['is_course_finished'] = 1;
                $this->finishCourse($data['course']->id , $data['user']->id);
            }
        }
        if ($course->type =='live'){
            $data['item_type'] = config('constants.item_model_types.'.$type);

            $data['groups'] = $course->groups()->with('sessions')->distinct()->get();
            $data['sessions'] = CourseSession::where('course_id',$course_id)->get();

            return $data;
        }
        return $data;
    }

    public function getLastCompletedItem($course_id)
    {
        // Get the last item relation the user finished
        $target_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $course_id)->allCompletedItems()->order('desc')->first();

        // Get the first item if the user didn't complete anything before
        if (!$target_item){
            $first_cur_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $course_id)->order('asc')->first();

            if (!$first_cur_item)   abort(404);

            $target_item = $first_cur_item;
        }

        // If the last finished item is inside a section get the section_item relation also

        if ($target_item->itemable_type == "App\Models\CourseSections") {
            $data['curclm_item_id'] = $target_item->id;

            $last_completed_section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_id', $course_id)
                ->where('course_sections_id', $target_item->itemable_id)
                ->allCompletedItems()->orderBy('id','desc')->first();

            if ($last_completed_section_item) {
                $target_item = $last_completed_section_item;
            }
            else {

                $first_section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_id', $course_id)
                    ->where('course_sections_id', $target_item->itemable_id)
                    ->orderBy('id','asc')->first();

                if (!$first_section_item)   abort(404);

                $target_item = $first_section_item;
            }
        }

        // define the target item relation

        if (!$target_item)  abort(404);

        return $target_item;
    }

    public function getCurSectionItem($course_id, $curclm_item_id, $section_item_id)
    {
        $course = Courses::withTrashed()->whereId($course_id)->with('items');

        if (Auth::guard('web')->check()) {
            if (checkUser('student')) $course = $course->active()->accepted();
        }

        $course = $course->first();

        if(!$course)    return false;
        if(!$course)    abort(404);

        // if there is no course or no curriculum items in the course send him to 404
        if (!$course->items->isNotEmpty())  return false;
        if (!$course->items->isNotEmpty())  abort(404);
        else {

            // Target item not defined so the user will be sent to the last element he finished in the course
            if (!$curclm_item_id) {

                $data['c_item'] = $this->getLastCompletedItem($course_id);
            }

            // Get defined item
            else{
                $curr_item = CourseCurriculum::activeStatusBasedOnUser()->where('id',$curclm_item_id)->first();

                if (!$curr_item)  abort(404);

                // Check if user require check the follow up functionality
                $need_check_follow_up = true;

                if (Str::contains(request()->url(), 'admin')) {
                    $user_type = "admin";
                }
                else if (Str::contains(request()->url(), 'lecturer')) {
                    $user_type = "lecturer";
                }

                if (@$user_type) {
                    switch ($user_type) {
                        case 'lecturer':
                            if (checkUser('lecturer')) {
                                $need_check_follow_up = false;
                            }
                            break;

                        case 'admin':
                            if (auth('admin')->user()){
                                $need_check_follow_up = false;
                            }
                            break;

                        default:
                            $need_check_follow_up = true;
                            break;
                    }
                }

                if ($curr_item->itemable_type != "App\Models\CourseSections") {

                    if ($course->lessons_follow_up && !$curr_item->canAccess() && @$need_check_follow_up) {
                        $data['c_item'] = $this->getLastCompletedItem($course_id);
                        $data['error_message'] = __('cannot_access_curriculum_item');
                    }
                    else
                        $data['c_item'] = $curr_item;

                } else {

                    $data['curclm_item_id'] = $curr_item->id;

                    if ($section_item_id)
                        $section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_sections_id', $curr_item->itemable_id)
                            ->where('id', $section_item_id)->first();
                    else
                        $section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_sections_id', $curr_item->itemable_id)->first();

                    if (!$section_item)  abort(404);

                    if ($course->lessons_follow_up && (!$curr_item->canAccess() || !$section_item->canAccess()) && @$need_check_follow_up) {
                        $data['c_item'] = $this->getLastCompletedItem($course_id);
                        $data['error_message'] = __('cannot_access_curriculum_item');

                        return $data;
                    }

                    $data['c_item'] = $section_item;
                }
            }

            // There is no content
            if (!@$data['c_item'])  abort(404);
        }

        return $data;
    }

    public function getCourseItem($type, $item_id)
    {
        $data = [];
        if ($type == 'lesson') {

            $data['course_item'] = CourseLessons::activeStatusBasedOnUser()->where('id', $item_id)->with('attachments', 'comments', 'course')->first();
        }
        else if ($type == 'quiz') {
            $data['course_item'] = CourseQuizzes::activeStatusBasedOnUser()->where('id', $item_id)
                ->withStudentStatusAndGrade()
                ->with('quizQuestions')
                // ->with('quizResults')
                ->withCount('quizQuestions')->first();

            if (@$data['course_item']->student_status) {
                $data['student_solutions'] = json_decode($data['course_item']->studentQuizResults[0]->results, true);
            }
        }
        else if ($type == 'assignment') {
            $data['course_item'] = CourseAssignments::activeStatusBasedOnUser()->where('id', $item_id)
                ->withStudentStatusAndGrade()
                ->with('assignmentQuestions')
                // ->with('assignmentResults')
                ->withCount('assignmentQuestions')->first();

            if (@$data['course_item']->student_status) {
                $data['student_solutions'] = json_decode($data['course_item']->studentAssignmentResults[0]->results, true);
            }
        }

        // dd($data);

        return $data;
    }

    function finishCourse($course_id , $user_id){
        UserCourse::where('course_id' , $course_id)->where('user_id' , $user_id )->update([
            "is_end" => 1
        ]);
        return;
    }

    public function openLearnPageByItemId($course_id, $type, $item_id, $is_web = true)
    {

        $type = array_search($type,config('constants.item_model_types'));

        $data['user'] = $this->getUser($is_web);
        $course = $this->getCourse($course_id);

        if ($course =='')               abort(404);

        $data['course_id'] = $course->id;

        $curclm_item = CourseCurriculum::
        when(!auth('admin')->check(),function($q){
            $q->activeStatusBasedOnUser();
        })
        ->where('course_id', $data['course_id'])
            ->where('itemable_type', $type)->where('itemable_id', $item_id)->first();

        if ($curclm_item) {
            $data['target_curclm_item_id'] = $curclm_item->id;
        }
        else {

            $section_item = CourseSectionItems::where('course_id', $data['course_id'])
                ->where('itemable_type', $type)->where('itemable_id', $item_id)->first();

            if (!$section_item) abort(404);

            $curclm_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $course->id)
                ->where('itemable_type', 'App\Models\CourseSections')->where('itemable_id', $section_item->course_sections_id)->first();

            if (!$curclm_item) abort(404);

            $data['target_curclm_item_id'] = $curclm_item->id;
            $data['target_section_item_id'] = $section_item->id;

        }
        if (!$data['target_curclm_item_id']) abort(404);

        return $data;
    }

    public function navigation($type, $course_id, $curclm_item_id, $section_item_id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);
        $course=$this->getCourse($course_id);

        if ($course =='')               abort(404);

        // if (!$course->isSubscriber())   abort(403);

        $data['course_id'] = $course->id;

        $current_cur_item = CourseCurriculum::activeStatusBasedOnUser()->whereId($curclm_item_id)->first();

        if (!$current_cur_item)
            $current_cur_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $course_id)
        // ->order('asc')
        ->orderBy('id','asc')
        ->first();

        if ($type == 'next')
        {
            $next_cur_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $data['course_id'])
                        ->where('id', '>', $current_cur_item->id)
                        // ->order('asc')
                        ->orderBy('id','asc')
                        ->first();

            if ($current_cur_item->item_type != 'section') {

                if ($next_cur_item)
                    $data['target_curclm_item_id'] = $next_cur_item->id;
                else
                    $data['target_curclm_item_id'] = $current_cur_item->id;

            } else {
                $current_section_item = CourseSectionItems::activeStatusBasedOnUser()->whereId($section_item_id)->first();

                if(!$current_section_item){
                    $current_section_item = CourseSectionItems::activeStatusBasedOnUser()->whereId($current_cur_item->item_id)
                    // ->order('asc')
                    ->orderBy('id','asc')
                    ->first();
                }

                $next_section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_sections_id', $current_section_item->course_sections_id)
                        // ->order('asc')
                        ->orderBy('id','asc')
                        ->where('id', '>', $current_section_item->id)->first();

                if ($next_section_item) {
                    $data['target_curclm_item_id'] = $current_cur_item->id;
                    $data['target_section_item_id'] = $next_section_item->id;
                }
                // Here it reaches the the last item of the curriculum so it should stay at it
                else if($section_item_id && !$next_section_item && !$next_cur_item) {
                    $data['target_curclm_item_id'] = $current_cur_item->id;
                    $data['target_section_item_id'] = $current_section_item->id;
                }
                else
                {
                    if ($next_cur_item)
                        $data['target_curclm_item_id'] = $next_cur_item->id;
                    else
                        $data['target_curclm_item_id'] = $current_cur_item->id;

                }
            }
        }
        else if ($type == 'back')
        {
            $previous_cur_item = CourseCurriculum::activeStatusBasedOnUser()->where('course_id', $data['course_id'])
                        ->where('id', '<', $current_cur_item->id)
                        // ->order('desc')
                        ->orderBy('id','desc')
                        ->first();

            if ($current_cur_item->item_type != 'section') {

                if ($previous_cur_item)
                    $data['target_curclm_item_id'] = $previous_cur_item->id;
                else
                    $data['target_curclm_item_id'] = $current_cur_item->id;

            } else {

                $current_section_item = CourseSectionItems::activeStatusBasedOnUser()->whereId($section_item_id)->first();

                if(!$current_section_item){
                    $current_section_item = CourseSectionItems::activeStatusBasedOnUser()->whereId($current_cur_item->item_id)->first();
                }

                $previous_section_item = CourseSectionItems::activeStatusBasedOnUser()->where('course_sections_id', $current_section_item->course_sections_id)
                        // ->order('desc')
                        ->orderBy('id','desc')
                        ->where('id', '<', $current_section_item->id)->first();

                if ($previous_section_item) {
                    $data['target_curclm_item_id'] = $current_cur_item->id;
                    $data['target_section_item_id'] = $previous_section_item->id;
                }
                // Here it reaches the the last item of the curriculum so it should stay at it
                else if($section_item_id && !$previous_section_item && !$previous_cur_item) {
                    $data['target_curclm_item_id'] = $current_cur_item->id;
                    $data['target_section_item_id'] = $current_section_item->id;
                }
                else
                {
                    if ($previous_cur_item){
                        if ($previous_cur_item->item_type == 'section') {
                            $last_item = CourseSectionItems::activeStatusBasedOnUser()
                                ->where('course_sections_id', $previous_cur_item->item_id)
                                // ->order('desc')
                                ->orderBy('id','desc')
                                ->first();

                            $data['target_curclm_item_id'] = $previous_cur_item->id;
                            $data['target_section_item_id'] = $last_item->id;
                        }
                        else $data['target_curclm_item_id'] = $previous_cur_item->id;

                    }
                    else
                        $data['target_curclm_item_id'] = $current_cur_item->id;

                }
            }
        }

        return $data;
    }

    public function previewCourse($course_id)
    {
        $data['course'] = Courses::select(
                'id',
                'user_id',
                'image',
                'cover_image',
                'welcome_text_for_registration_image',
                'certificate_text_image',
                'faq_image',
                'video',
                'video_type',
                'video_image',
                'start_date',
                'type',
                'category_id',
                'level_id',
                'age_range_id',
                'is_active',
                'language_id',
                'start_date',
                'duration',
            )
            ->with('translations:courses_id,title,locale,description,welcome_text_for_registration,certificate_text')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'language' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'level' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'age_range' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'faqs' => function ($query) {
                    $query->select('id', 'course_id', 'faq_id', 'is_active', 'order')->active()
                        ->with([
                            'faq' => function ($query) {
                                $query->select('id', 'order')
                                    ->with('translations:faqs_id,title,text,locale');
                            }
                        ]);
                }
            ])
            ->with([
                'reviews' => function ($query) {
                    $query->select(
                        'id',
                        'sourse_type',
                        'sourse_id',
                        'user_id',
                        'rate',
                        'comment_text',
                        'is_active',
                    )->active()
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'name', 'image');
                            }
                        ]);
                }
            ])
            ->with([
                'whatWillYouLearn' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'forWhomThisCourse' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'content' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'priceDetails' => function ($query) {
                    $query->select('id', 'course_id', 'price');
                }
            ])
            ->with([
                'lecturers' => function ($query) {
                    $query->select('id', 'name', 'image')
                        ->with([
                            'lecturerSetting' => function ($query) {
                                $query->select('id', 'user_id')
                                ->with('translations:lecturer_setting_id,position,abstract,locale');
                            }
                        ]);
                }
            ])
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),

                'is_end' => UserCourse::select('is_end')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),

                'is_rating' => UserCourse::select('is_rating')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),
            ])
            ->withCount('items')
            ->withCount('students')
            ->where('id', $course_id)->first();

            // dd($data['course']);

            if (!$data['course']) abort(404);

        return $data;
    }

    public function setLessonAsCompleted($course_id, $id, $type, $is_web = true)
    {
        $user_id = auth()->id();

        $course=$this->getCourse($course_id);

        if (!$course)   abort(404);
        if (!$course->isSubscriber())   abort(403);

        if ($type == 'normal')
            $lesson = CourseLessons::active()->whereId($id)->first();
        else
            $lesson = CourseLiveLesson::active()->whereId($id)->first();


        if (!$lesson)   abort(404);

        $is_completed = CourseLessonsLearning::where([
            'lesson_id' => $id,
            'user_id' => $user_id,
            'lesson_type' => $type,
        ])->first();

        if (!$is_completed) {
            $lesson = CourseLessonsLearning::create([
                'lesson_id' => $id,
                'user_id' => $user_id,
                'lesson_type' => $type,
            ]);

            $course->updateProgress();
        }

        return true;
    }

    public function saveComment($request, $course_id, $is_web = true)
    {
        DB::beginTransaction();

        $user = $this->getUser($is_web);

        try {

            $data = $request->all();

            $course = Courses::active()->accepted()->find($course_id);
            if (!$course) {

                $message = "الدورة المراد التعليق عليها غير متوفرة!";
                $status = false;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

            if (!$course->isSubscriber()) {

                $message = "أنت غير مسجل في هذه الدورة";
                $status = false;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

            switch ($data['item_type']) {
                case 'lesson':
                    $item = CourseLessons::find($data['item_id']);
                    break;

                case 'quizz':
                    $item = CourseQuizzes::find($data['item_id']);
                    break;

                case 'assignment':
                    $item = CourseAssignments::find($data['item_id']);
                    break;

                case 'live_lesson':
                    $item = CourseLiveLesson::find($data['item_id']);
                    break;

                default:
                    $message = "المحتوى المراد التعليق عليه غير معرف!";
                    $status = false;
                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];
                    return $response;
                    break;
            }
            if (!$item) {

                $message = "المادة المراد التعليق عليها غير متوفرة!";
                $status = false;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }


            $data['user_id'] = $user->id;

            $comment = CourseComments::updateorCreate(['id' => 0], $data);

            //sendNotification
            $title = 'تعليق على درس';
            $text = "قام " . $user->name . " بالتعليق على درسك: " . $item->title;
            $notification['title'] = $title;
            $notification['text'] = $text;
            $notification['user_type'] = 'user';
            $notification['action_type'] = 'comment_on_course_lesson';
            $notification['action_id'] = $item->id;
            $notification['created_at'] = \Carbon\Carbon::now();

            $teacher_id = $course->user_id;
            $notification['user_id'] = $teacher_id;

            Notifications::insert($notification);
            sendWebNotification($teacher_id, 'user', $title, $text);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            DB::rollback();
        }

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function getCourse($course_id)
    {
        $course = Courses::withTrashed()->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','lessons_follow_up')
        ->with('translations:courses_id,title,locale,description')
        ->where('id', $course_id)
        ->addSelect([
            'is_end' => UserCourse::select('is_end')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id())->limit(1),

            'is_rating' => UserCourse::select('is_rating')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id())->limit(1),
        ]);


        if (Auth::guard('web')->check()) {
            if (checkUser('student')) $course = $course->active();
            // ->accepted();
        }

        $course = $course->first();
        return $course;
    }

    public function startLiveLesson($id, $is_web=true)
    {

        $data['user'] = $this->getUser($is_web);

        $lesson = CourseLiveLesson::where('id', $id)->first();

        if ($lesson=='') {
            abort(404);
        }

        if ($lesson->canStartMeeting()) {
            $live_lesson_id='live_lesson_id_'.$id;

            $meeting_name = $lesson->title;

            $item=\Bigbluebutton::create([
                'bannerText' => $meeting_name,
                'meetingID' => $live_lesson_id,
                'meetingName' => $meeting_name,
                'record'=>true,
                'attendeePW' => 'attendee',
                'moderatorPW' => 'moderator',
                'endCallbackUrl'  => route('user.set.meeting.finished', ['id' => $id]),
                'logoutUrl' => route('user.set.meeting.finished', ['id' => $id]),
             ]);



            $url=
                \Bigbluebutton::join([
                   'meetingID' => $live_lesson_id,
                   'userName' => auth()->user()->name,
                   'role'=>'MODERATOR',
                   'password' => 'moderator' // which user role want to join set password here
                ]);


            $lesson->meeting_link = $url;
            $lesson->meeting = "going_on";
            $lesson->update();

            $data['url']=$url;
            $data['status']=true;

            return $data;

        }

        $data['url']=back()->withInput();
        $data['status']=false;

        return $data;

    }


    public function joinLiveLesson($id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);


        $session = CourseLiveLesson::where('id', $id)
            ->whereNotNull('meeting_link')->first();

        if ($session=='') {
            abort(404);
        }

        if ($session->canStartMeeting()) {
            $live_lesson_id = 'live_lesson_id_'.$id;

            $url=
                \Bigbluebutton::join([
                   'meetingID' => $live_lesson_id,
                   'userName' => auth()->user()->name,
                   'role'=>'MODERATOR',
                   'password' => 'attendee' //which user role want to join set password here
                ]);


            $data['url']=$url;
            $data['status']=true;

            return $data;
        }

        $data['url']=back()->withInput();
        $data['status']=false;

        return $data;

    }

    public function setMeetingFinished($id, $is_web=true)
    {

        $data['user'] = $this->getUser($is_web);

        $lesson = CourseSession::where('id', $id)->first();

        if ($lesson=='') {
            abort(404);
        }

        // $getRecordingsParams = new GetRecordingsParameters();
        // $live_lesson_id = 'live_lesson_id_'.$lesson->id;
        // $getRecordingsParams->meetingId = $live_lesson_id;

        // $recordings = \Bigbluebutton::getRecordings($getRecordingsParams);

        // if (!empty($recordings)) {
        //     $firstRecording = $recordings[0];

        //     $playbackURL = $firstRecording['playback']['format'][0]['url'];

        //     $lesson->recording_link = $playbackURL;
        // }

        $lesson->meeting_status = "finished";
        $lesson->update();

        return true;

    }

    public function showRecording($id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $session = CourseLiveLesson::where('id', $id)
            ->whereNotNull('recording_link')->first();

        if ($session=='') {
            abort(404);
        }

        $url=$session->recording_link;


        $data['url']=$url;
        $data['status']=true;

        return $data;
    }

    public function getItemApi($id,$type){


        switch ($type){
            case 'lesson' :
                $data['data'] = new ApiCurriculumLessonResource(CourseLessons::where('id',$id)->with('translations','attachments')->first());
                break;
            case 'quiz' :
                $data['data'] = new ApiCurriculumQuizResource(CourseQuizzes::where('id',$id)->with('translations')->first());
                break;

            case 'assignment' :
                $data['data'] = new ApiCurriculumAssignmentResource(CourseAssignments::where('id',$id)->with('translations')->first());
                break;

        }

        return $data;
    }


}
