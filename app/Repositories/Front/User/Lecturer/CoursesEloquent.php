<?php

namespace App\Repositories\Front\User\Lecturer;

use App\Http\Resources\GetTeacherMyCategoriesResource;
use Carbon\Carbon;
use App\Models\Faqs;
use App\Models\Admin;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Category;
use App\Models\CourseFaqs;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\CourseQuizzes;
use App\Models\CourseSession;
use App\Models\Notifications;
use App\Models\CourseComments;

use App\Models\CourseSections;
use GPBMetadata\Google\Api\Log;
use App\Models\CourseLiveLesson;
use App\Models\AddCourseRequests;
use App\Models\CourseAssignments;
use App\Models\CoursePriceDetails;
use App\Models\CourseRequirements;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSessionsGroup;
use App\Models\CourseContentDetails;
use App\Models\CourseQuizzesResults;
use App\Models\CourseSuggestedDates;
use App\Models\CourseAssignmentResults;
use Illuminate\Database\Eloquent\Builder;
use App\Models\CourseAssignmentsResultsAnswer;
use App\Repositories\Front\User\HelperEloquent;
use App\Repositories\Common\LiveSessionEloquent;
use App\Http\Resources\InCourseStudentCollection;
use App\Http\Resources\LecturerCourseQuizResource;
use App\Http\Resources\Quiz\ShowResultQuestionResource;
use App\Models\CourseQuizzesQuestionsAnswerTranslation;
use App\Http\Resources\LecturerCourseAssignmentsResource;
use App\Http\Resources\LecturerCourseUserQuizzesCollection;
use App\Http\Resources\LecturerCourseUserAssignmentsCollection;
use App\Http\Resources\LecturerCourseUserAssignmentAnswerResource;
use App\Http\Resources\ShowAssignmentResource;
use App\Http\Resources\ShowQuizResource;
use App\Http\Resources\TeacherStudentHomeworksCollection;
use App\Models\CourseAssignmentQuestions;

class CoursesEloquent extends HelperEloquent
{
    public LiveSessionEloquent $liveSessionEloquent ;
    public function __construct(LiveSessionEloquent $liveSessionEloquent)
    {
        $this->liveSessionEloquent = $liveSessionEloquent;
    }

    public function myCourses($request, $is_web = true, $count_itmes = 10, $use_filters = true)
    {
        $data['user'] = $this->getUser($is_web);
        $user_id = $data['user']->id;
        $course_type = $request->get('course_type');

        $data['recorded_courses_count'] = Courses::active()->where('user_id', $user_id)->filterByType('recorded')->count();
        $data['live_courses_count'] = Courses::active()->where('user_id', $user_id)->filterByType('live')->count();
        $data['published_courses_count'] = Courses::active()->where('user_id', $user_id)->filterByStatus(['accepted'])->count();
        $data['waiting_courses_count'] = Courses::active()->where('user_id', $user_id)->where('status', '!=', 'accepted')->count();
        $data['students_count'] = UserCourse::where('lecturer_id', $user_id)->count();

        $totla_sales = Courses::active()->where('user_id', $user_id)->sum('total_sales');
        if($data['user']->country) {
            $data['total_sales'] = ceil($data['user']->country->currency_exchange_rate*$totla_sales) . " ".$data['user']->country->currency_name;
        } else {
            $data['total_sales'] = $totla_sales . ' $';
        }

        $data['materials']  = Category::getCategoriesByParent('course_categories')->orderByDesc('created_at')->get();

        $data['languages']  = Category::getCategoriesByParent('course_languages')->orderByDesc('created_at')->get();

        $data['levels']  = Category::getCategoriesByParent('course_levels')->orderByDesc('created_at')->get();
        $data['grade_levels']  = Category::getCategoriesByParent('grade_levels')->orderBy('order','asc')->get();

        $data['age_categories']  = Category::getCategoriesByParent('age_categories')->orderByDesc('created_at')->get();


        $data['courses'] = Courses::active()
            ->where('user_id', $user_id)
            ->select(
                'id',
                'image',
                'start_date',
                'type',
                'category_id',
                'is_active',
                'number_of_free_lessons',
                'duration',
                'status',
                'total_sales',
                'created_at',
                'material_id',
                'grade_sub_level',
                'user_id'
            )
            ->with('translations:courses_id,title,locale,description')
            ->with('evaluation')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'material' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->withCount('students')
            ->orderBy('id', 'desc');

            $title = $request->get('title');
            if ($title != '') {
                $data['courses'] = $data['courses']->filterByTitle($title);
            }

            $price_type = $request->get('price_type');
            if ($price_type != '') {
                $data['courses'] = $data['courses']->filterByPrice($price_type);
            }

            $course_type = $request->get('course_type');
            if ($course_type != '') {
                $data['courses'] = $data['courses']->filterByType($course_type);
            }

            try {
                $material_ids = $request->get('material_ids');
                if ($material_ids) {
                    $data['courses'] = $data['courses']->filterByCategories(json_decode($material_ids));
                }
            } catch (\Exception $e) {
            }

            try {
                $material_id = $request->get('material_id');
                if ($material_id) {
                    $data['courses'] = $data['courses']->filterByCategories2($material_id);
                }
            } catch (\Exception $e) {
            }

            try {
                $language_ids = $request->get('language_ids');
                if ($language_ids) {
                    $data['courses'] = $data['courses']->filterByLanguages(json_decode($language_ids));
                }
            } catch (\Exception $e) {
            }

            try {
                $level_ids = $request->get('level_ids');
                if ($level_ids) {
                    $data['courses'] = $data['courses']->filterByLevels(json_decode($level_ids));
                }
            } catch (\Exception $e) {
            }

            try {
                $age_range_ids = $request->get('age_range_ids');
                if ($age_range_ids) {
                    $data['courses'] = $data['courses']->filterByAgeRanges(json_decode($age_range_ids));
                }
            } catch (\Exception $e) {
            }

            try {
                $statuses = $request->get('statuses');
                if ($statuses) {
                    $data['courses'] = $data['courses']->filterByStatus(json_decode($statuses));
                }
            } catch (\Exception $e) {
            }
            try {
                $status = $request->get('status');
                if ($status) {
                    $data['courses'] = $data['courses']->filterByStatus2($status);
                }
            } catch (\Exception $e) {
            }


            $data['courses'] = $data['courses']->paginate($count_itmes);
        return $data;
    }

    public function myLiveLessons($is_web=true)
    {
        $user = $this->getUser($is_web);
        $data['live_lessons_groups'] = Courses::where('user_id', $user->id)
                                 ->where('type', 'live')
                                 ->whereHas('groups', function ($query) {
                                     $query->whereHas('sessions'); // Ensure the group has sessions
                                 })
                                 ->with(['groups' => function ($query) {
                                     $query->distinct()->with(['sessions' => function ($sessionQuery) {
                                         $sessionQuery->distinct()->whereNotNull('group_id'); // Ensure only sessions with a group_id
                                     }]);
                                 }])
                                 ->get();

        return $data;
    }

    public function create($is_web = true)
    {
        $data['user'] = $this->getUser($is_web);
        $data['languages']        = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'course_languages')
            ->orderByDesc('created_at')->get();

        $data['levels']          = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'course_levels')
            ->orderByDesc('created_at')->get();

        $data['grade_levels']      = Category::where('key', 'grade_levels')->orderBy('order','asc')->get();
        $data['materials'] = Category::query()->select('id', 'value', 'parent')
        ->with('translations:category_id,name,locale')
        ->where('parent', 'joining_course')
        ->orderByDesc('created_at')->get();

        $data['age_categories'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'age_categories')
            ->orderByDesc('created_at')->get();
        return $data;
    }

    public function addCourse($request, $is_web = true)
    {

        DB::beginTransaction();
        try {

            $videoType = $request->input('video_type');

            if ($videoType == 'link') {
                $request['video'] = $request->input('video_link');
            } elseif ($videoType == 'file') {
                if ($request->file('video_file')) {
                    $videoFile = $request->file('video_file');

                    $request['video'] = uploadvideo($videoFile);
                }
            }

            $data = $request->all();
            if ($request->get('start_date')) {
                $data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            }
            if ($request->get('end_date')) {
                $data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));
            }
            $user            = $this->getUser($is_web);
            $data['user_id'] = $user->id;
            $data['grade_level_id'] = $request->grade_level_id;
            $data['grade_sub_level'] = $request->grade_sub_level;
            $course = Courses::updateOrCreate(['id' => 0], $data)->createTranslation($request);

            $request_course = $course->evaluation()->create([
                'status' => 'pending'
            ]);

            // Notify Admin
            $title                       = 'طلب مراجعة دورة جديدة ';
            $text                        = "قام " . $user->name . " بإضافة دورة جديدة: " . $course->title . ' وفي إنتظار المراجعة.';
            sendNotifications($title, $text , 'add_course_requests' , $request_course->id , 'show_add_course_requests' , 'admin');

            // Notify User
            $this->notify_lecturer_course_request($user  , $course);


            if ($request->file('image')) {
                //path
                $image                  = uploadImageBySendingFile( $request->file('image'));
                $course->image          = str_replace('/', '-', $image);
            }

            if ($request->file('cover_image')) {
                //path
                $cover_image            = uploadImageBySendingFile( $request->file('cover_image'));
                $course->cover_image    = str_replace('/', '-', $cover_image);
            }

            if ($request->file('video_image')) {
                //path
                $video_image            = uploadImageBySendingFile( $request->file('video_image'));
                $course->video_image    = str_replace('/', '-', $video_image);
            }
            $course->save();
            $message = __('message_done');
            $status = true;
            DB::commit();
            $redirect_url= route('user.lecturer.my_courses.edit.baseInformation.index' , $course->id);
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
            $redirect_url= '#';
            \Illuminate\Support\Facades\Log::alert($e->getMessage());
        }


        $response = [
            'message' => $message,
            'status' => $status,
            'course_id'  => @$course->id,
            'redirect_url'=>$redirect_url
        ];

        return $response;
    }

    function notify_lecturer_course_request($lecturer  , $course) {
        $title                       = 'طلب إضافة دورة جديدة ';
        $text                        = " تم إرسال طلب إضافة دورة جديدة: " . $course->title . ' وفي إنتظار المراجعة.';
        $notification['title']       = $title;
        $notification['text']        = $text;
        $notification['user_type']   = 'user';
        $notification['action_type'] = 'add_course_requests';
        $notification['action_id']   = $course->id;
        $notification['created_at']  = \Carbon\Carbon::now();

        $notification['user_id']    = $lecturer->id;

        Notifications::insert($notification);
        sendWebNotification($lecturer->id, 'user', $title, $text);
        return true;
    }


    public function getCourse($id, $user_id, $is_web = true)
    {
        $data['course'] = Courses::active()
            ->where('id', $id)
            ->select(
                'id',
                'image',
                'start_date',
                'type',
                'category_id',
                'is_active',
                // 'number_of_free_lessons',
                // 'duration_in_months',
                //  'num_weekly_lessons',
                //  'allow_adding_groups',
                'created_at',
            )
            /*  ->with([
                'levels' => function ($query) {
                    $query->select('id', 'course_id', 'level_id')
                        ->with([
                            'level' => function ($query) {
                                $query->select('id', 'value', 'parent')
                                    ->with('translations:category_id,name,locale');
                            }
                        ]);
                }
           ])*/
            ->with('level', function ($query) {
                $query->select('id', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            })
            ->with('translations:courses_id,title,locale,description')
            /* ->with([
            'groups' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }
            ])*/
            ->whereHas('lecturers', function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->first();

        if ($data['course'] == '') {
            // abort(404);
        }
        return $data;
    }

    public function requestReview($is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        return $data;
    }


    public function edit($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);
        $data = $this->create();
        $data['item'] = Courses::where('id', $id)
            ->with(['lecturers:id,name'])
            ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {

            $course = Courses::where('id', $id)->first();

            if(!$course)    abort(404);

            $data = $request->all();

            if ($request->get('start_date')) {
                $data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            }

            if ($request->get('end_date')) {
                $data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));
            }

            $videoType = $request->input('video_type');

            if ($videoType == 'link') {

                if ($request->input('video_link')) {
                    $data['video'] = $request->input('video_link');
                }
                else if (@$course->video_type != null && @$course->video != null)
                {
                    $data['video_type'] = @$course->video_type;
                    $data['video'] = @$course->video;
                }
                else
                    $data['video_type'] = null;

            }
            elseif ($videoType == 'file') {
                if ($request->file('video_file')) {
                    $videoFile = $request->file('video_file');

                    $data['video'] = uploadvideo($videoFile);
                }
                else if (@$course->video_type != null && @$course->video != null)
                {
                    $data['video_type'] = @$course->video_type;
                    $data['video'] = @$course->video;
                }
                else
                    $data['video_type'] = null;
            }
            $data['grade_level'] = $request->grade_level_id;
            $data['grade_sub_level'] = $request->grade_sub_level;
            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);

            if ($request->file('image')) {
                //path
                $image                  = uploadImageBySendingFile( $request->file('image'));
                $course->image          = str_replace('/', '-', $image);
            }

            if ($request->file('cover_image')) {
                //path
                $cover_image            = uploadImageBySendingFile( $request->file('cover_image'));
                $course->cover_image    = str_replace('/', '-', $cover_image);
            }

            if ($request->file('video_image')) {
                //path
                $video_image            = uploadImageBySendingFile( $request->file('video_image'));
                $course->video_image    = str_replace('/', '-', $video_image);
            }

            $course->save();

            $message = __('message_done');
            $status = true;
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];
        return $response;
    }

    public function editWelcomeTextForRegistration($id)
    {
        $data['item'] = Courses::where('id', $id)
            ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        $data['introductory_text_for_course_registration'] =
            $data['item'];

        return $data;
    }

    public function editSuggestedDates($id)
    {
        $data['item'] = Courses::where('id', $id)
            ->with('lecturers')
            ->with('suggestedDates')
            ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        $data['lecturers'] = $data['item']->lecturers;

        $data['suggested_dates'] = $data['item']->suggestedDates->where('is_booked_before', 0);

        return $data;
    }

    public function updateSuggestedDates($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $suggested_dates = $request->get('suggested_dates');

            $suggested_date_ids = [];
            foreach ($suggested_dates as $suggested_date) {
                $suggested_date_ids[] = $suggested_date['suggested_date_id'];
            }

            //delete all appointments that do not exist
            CourseSuggestedDates::where('course_id', $id)
                ->whereNotIn('id', $suggested_date_ids)
                ->delete();

            foreach ($suggested_dates as $suggested_date) {

                $suggested_date_id = $suggested_date['suggested_date_id'];
                $data['course_id'] = $id;
                $data['date'] = $suggested_date['start_date'] . ' ' . $suggested_date['start_time'];
                $data['start_date'] = $suggested_date['start_date'];
                $data['start_time'] = $suggested_date['start_time'];
                $data['is_active'] = $suggested_date['is_active'];

                //Check for scheduling conflicts
                $item = CourseSuggestedDates::where('course_id',$id)
                    ->where('date', $data['date'])
                    ->where('id', '!=', $suggested_date_id)
                    ->first();

                if ($item) {
                    $lecturer_name = $item->lecturer->name;
                    $date = $item->date;
                    $course_title = $item->course->title;
                    if ($item->course_id == $id) {
                        $message = " $lecturer_name لديه تعارض بالموعد $date";
                    } else {
                        $message = " $lecturer_name لديه تعارض بالموعد $date بدورة $course_title ";
                    }
                    $status = false;
                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;

                }


                CourseSuggestedDates::updateOrCreate(['id' => $suggested_date_id], $data);

            }


            $message = __('message_done');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            dd($e);
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function updateWelcomeTextForRegistration($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);
            if ($request->file('welcome_text_for_registration_image')) {
                //path
                $welcome_text_for_registration_image            = uploadImageBySendingFile($request->file('welcome_text_for_registration_image'));
                $course->welcome_text_for_registration_image    = str_replace('/', '-', $welcome_text_for_registration_image);
            }

            if ($request->file('certificate_text_image')) {
                //path
                $certificate_text_image          = uploadImageBySendingFile($request->file('certificate_text_image'));
                $course->certificate_text_image  = str_replace('/', '-', $certificate_text_image);
            }

            if ($request->file('faq_image')) {
                //path
                $faq_image           = uploadImageBySendingFile($request->file('faq_image'));
                $course->faq_image   = str_replace('/', '-', $faq_image);
            }
            $course->save();
            $message = __('message_done');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message =  __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editPriceDetails($id)
    {
        $data['item'] = Courses::where('id', $id)
            ->with(['priceDetails'])
            ->first();
        if ($data['item'] == '') {
            abort(404);
        }
        return $data;
    }

    public function updatePriceDetails($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            CoursePriceDetails::updateOrCreate(['course_id' => $id], $data);
            $message = __('message_done');
            $status = true;
            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function updateRequestReview($id,$request , $is_web = true)
    {
        DB::beginTransaction();
        try {
            $user = $this->getUser($is_web);

            $course = Courses::where('id', $id)
                ->where('user_id', $user->id)
                ->with(['lecturers:id,name'])
                ->first();

            if (!$course) abort(404);

            $course_items = $course->items()->active()->get();

            if($course_items->isEmpty()){
                $message = "لا يمكنك طلب مراجعة دون اضافة عناصر المنهج";
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }

            // $is_exist = AddCourseRequests::where('courses_id', $course->id)->first();

            // if (!$is_exist) {
            $new_request = AddCourseRequests::create([
                'courses_id'     => $course->id,
                'created_at'     => now(),
            ]);

            $course->status = Courses::READY;
            $course->update();
            // }


            $message = __('message_done');
            $status = true;
            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
            'redirect_url' => $request->redirect_url
        ];

        return $response;
    }

    public function waitingEvaluation($id, $is_web = true)
    {
        $data['user']            = $this->getUser($is_web);

        $data['item']          = Courses::find($id);

        if (!$data['item'])    abort(404);

        return $data;
    }

    public function unacceptedEvaluation($id, $is_web = true)
    {
        $data['user']            = $this->getUser($is_web);

        $data['item']          = Courses::find($id);

        if (!$data['item'])    abort(404);

        $data['evaluation'] = AddCourseRequests::where('courses_id', $id)->orderBy('id', 'desc')->first();

        if (!$data['evaluation'])    abort(404);

        return $data;
    }

    public function editContentDetails($id, $type)
    {
        $data['item'] = Courses::where('id', $id)
            ->with(array('contentDetails' => function ($query) use ($type) {
                $query->where('type', $type);
            }))
            ->first();

        if ($data['item'] == '') {
            abort(404);
        }
        $data['title'] = __($type);
        $data['type'] = $type;
        return $data;
    }

    public function updateContentDetails($id, $type, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $content_details = $request->content_details;
            //delete CourseContentDetails
            //   CourseContentDetails::where('course_id', $id)->delete();
            $delete_item = array(0);
            if (isset($content_details)) {
                foreach ($content_details as $course_content_details) {
                    $request_content_details = new Request();
                    foreach (array_keys($course_content_details) as $key) {
                        $request_content_details->request->add([$key => $course_content_details[$key]]);
                    }

                    if (isset($course_content_details['icon'])) {
                        $content_details_icon = uploadImageBySendingFile($course_content_details['icon']);
                        $request_content_details['image'] = str_replace('/', '-', $content_details_icon);
                    }
                    $request_content_details['course_id'] = $id;

                    $content_id = 0;
                    if (isset($course_content_details['id'])) {
                        $content_id = $course_content_details['id'];
                        array_push($delete_item, $content_id);
                    }

                    $item = CourseContentDetails::updateOrCreate(['id' => $content_id, 'type' => $type], $request_content_details->all())->createTranslation($request_content_details);
                    array_push($delete_item, $item->id);
                }
            }


            CourseContentDetails::where('course_id', $id)->where('type', $type)->whereNotIn('id', $delete_item)
                ->delete();
            $message = __('message_done');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editCourseFaqs($id)
    {
        $data['item'] = Courses::where('id', $id)
            ->with(['faqs'])
            ->first();
        if ($data['item'] == '') {
            abort(404);
        }
        return $data;
    }

    public function updateCourseFaqs($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $faqs = $request->get('faqs');
            //delete faqs
            $faqs_id = CourseFaqs::where('course_id', $id)->pluck('faq_id')->toArray();
            Faqs::whereIn('id', $faqs_id)->delete();
            CourseFaqs::where('course_id', $id)->delete();
            $course_faqs = [];
            if (isset($faqs) > 0) {

                foreach ($faqs as $faq) {
                    $request_faq = new Request();

                    foreach (array_keys($faq) as $key) {
                        $request_faq->request->add([$key => $faq[$key]]);
                    }
                    $request_faq['type'] = 'course';
                    $item = Faqs::updateOrCreate(['id' => 0, 'order' => 0], $request_faq->all())->createTranslation($request_faq);

                    $course_faqs[] = [
                        'course_id' => $id,
                        'faq_id' => $item->id,
                    ];
                }

                CourseFaqs::insert($course_faqs);
            }
            $message = __('message_done');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function editCourseRequirements($id)
    {
        $data['item'] = Courses::where('id', $id)
            ->with('requirements')
            ->first();
        $data['courses'] = Courses::where('id', '!=', $id)->orderByDesc('created_at')->get();
        if ($data['item'] == '') {
            abort(404);
        }
        return $data;
    }

    public function updatetCourseeRequirements($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $requirements = $data['course_requirement_id'];
            if (!empty($requirements)) {
                foreach ($requirements as $requirement) {
                    $item = CourseRequirements::where(['course_id' => $id , 'course_requirement_id' => $requirement])->first();
                    if($item) {
                         continue;
                    }else {
                        $new_item = new CourseRequirements() ;
                        $new_item->course_id = $id;
                        $new_item->course_requirement_id = $requirement;
                        $new_item->save();
                    }
                }
            }

            $message = __('message_done');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    // Curriculum

    public function correctTask($request)
    {
        DB::beginTransaction();
        try {
            $data         = $request->all();
            $assignment    = CourseAssignments::where('id', $data['item_id'])->first();
            if ($assignment) {

                if(array_sum($data['grade'] ?? []) > $assignment->grad){
                    $message = app()->isLocale('en') ? 'Questions grades should be less than or equal to assignment grade' : 'يجب ان يكون مجموع درجات الاسئلة اقل من او مساويا لدرجة الامتحان';
                    return [
                        'message' => $message . " ($assignment->grad)",
                        'status' => false,
                    ];
                }

                $assignmentResult = CourseAssignmentResults::where('assignment_id', $data['item_id'])
                    ->where('student_id', $data['student_id'])
                ->first();

                if ($assignmentResult) {
                    $grades  = $data['grade'];
                    $results = json_decode($assignmentResult->results);
                    $i     = 0;
                    $total = 0;
                    // dd($results );
                    $updatedResults = [];
                    foreach (@$results ?? [] as $key => $result) {
                        $result->grade  = isset($grades[$i]) ? $grades[$i] : 0;
                        $total += isset($grades[$i]) ? $grades[$i] : 0;
                        $updatedResults[$key] = $result;
                        $i++;
                    }
                }

                $assignmentResult->results = json_encode($updatedResults);
                $assignmentResult->status  = ($assignment->pass_grade <= $total) ?  'passed' : 'not_passed';
                $assignmentResult->grade   = $total;
                $assignmentResult->save();
                $message = __('message_done');
                $status = true;
                DB::commit();
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function courseCurriculum($id, $is_web = true)
    {
        $data['user']            = $this->getUser($is_web);
        $data['course']          = Courses::find($id);
        $data['course_sections'] = Courses::with([
            'items.section' => function ($query) {
                $query->with('items.itemable');
            },
        ], 'items.itemable')->where('id', $id)->first();
        $data['item_types'] = config('constants.item_types');
        // $data['course_section'] = Courses::with([
        //     'items.section' => function ($query) {
        //         $query->with([
        //             'items.lesson' => function ($query) {
        //                 $query->take(2); // Limit the number of lessons to 5
        //             },
        //             'items.quiz' => function ($query) {
        //                 $query->take(2); // Limit the number of quizzes to 3
        //             },
        //             'items.assignment' => function ($query) {
        //                 $query->take(2); // Limit the number of assignments to 2
        //             },
        //         ]);
        //     },
        // ], 'items.lesson', 'items.quiz', 'items.assignment')->where('id', $id)->first();

        // dd( $data['course_sections']);
        return $data;
    }



    public function courseTasks($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);
        return $data;
    }

    public function tasks($courses_id , $is_web=true)
    {
        $data['user']        = $this->getUser($is_web);
        $data['course']      = Courses::where(['id' =>  $courses_id , 'user_id' =>  $data['user']->id])->first();
        $data['assignments'] = [];
        if($data['course']) {
            $data['assignments'] =  CourseAssignments::where('course_id',  $data['course']->id)
            ->with(['course'])->paginate(10);
        }
        return $data ;
    }

    public function task_students($assignment_id , $is_web=true)
    {
        $data['user']        = $this->getUser($is_web);
        $data['assignmentt']  =  CourseAssignments::where(['id' => $assignment_id  , 'user_id' =>   $data['user']->id ])
        ->with(['course'])->first();
        $data['assignments'] = [];
        if( $data['assignmentt']) {
            $data['assignments'] =  CourseAssignmentResults::where(['assignment_id' => $assignment_id ])
            ->with(['student'])
            ->paginate(10);
        }
        return $data ;
    }


    public function exams($courses_id , $is_web=true)
    {
        $data['user']     = $this->getUser($is_web);
        $data['course']   = Courses::where(['id' =>  $courses_id , 'user_id' =>  $data['user']->id])->first();
        if($data['course']) {
            $data['exams'] =  CourseQuizzes::where('course_id',  $data['course']->id)
            ->with(['course'])->paginate(10);
        }

        return $data ;
    }

    public function exam_students($quiz_id , $is_web=true)
    {
        $data['user']            = $this->getUser($is_web);
        $data['examm']           =  CourseQuizzes::where(['id' => $quiz_id  , 'user_id' =>   $data['user']->id ])
                                    ->with(['course'])->first();

        $data['exams'] =  null;
        if($data['examm']) {
            $data['exams'] =  CourseQuizzesResults::where(['quiz_id' => $quiz_id ])
            ->with(['user'])
            ->paginate(10);
        }
        return $data ;
    }

    public function certificates($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        return $data;
    }


    public function courseNotifications($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        return $data;
    }


    public function courseFaqs($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        return $data;
    }

    public function viewRatings($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['course'] = $this->getCourse($id, $data['user']->id)['course'];

        $data['reviews'] = Ratings::select(
            'id',
            'sourse_type',
            'sourse_id',
            'user_id',
            'rate',
            'comment_text',
            'is_active',
            'created_at'
        )->active()
            ->orderBy('id', 'desc')
            // ->where('sourse_id', $id)
            // ->where('sourse_type', Ratings::COURSE)
            ->where('sourse_id', $id)
            ->where('sourse_type', Ratings::COURSE)
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'image');
                }
            ])->paginate(10);

        return $data;
    }

    public function comments($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['course'] = $this->getCourse($id, $data['user']->id)['course'];
        $itemType = Courses::find($id) ? 'course_id' : 'item_id';

        $data['comments'] = CourseComments::select(
            'id',
            'text',
            'is_published',
            'item_type',
            'course_id',
            'created_at'
        )->orderBy('id', 'desc')
         ->where($itemType, $id)
         ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'image');
                }
            ])->with(['course'])->paginate(10);

        return $data;
    }

    public function delete_comment($id)
    {
        $item = CourseComments::find($id);
        if ($item) {
            $item->delete();
            $message =__('delete_done');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function publish_comment($request)
    {
        $id = $request->get('id');

        $item = CourseComments::find($id);
        if ($item) {
            $item->is_published = !$item->is_published;
            $item->update();
            $message = __('message_done');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function deleteCourse($request)
    {
        $course_id = $request->id;
        $course = Courses::with('students')->whereId($course_id)->first();

        if (!$course) {
            $message = __('message_error');
            $status = false;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $students = $course->students;

        if (count($students) > 0) {

            $message = "هذا الكورس يحتوي على طلاب لذلك لا يمكنك حذفه!";
            $status = false;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $course->deleteWithAssociations();

        $message =__('delete_done');
        $status = true;
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editCourseSchedule($id)
    {
       return $this->liveSessionEloquent->editCourseSchedule($id);
    }
    public function saveGroups(Request $request, int  $courseId)
    {
        return $this->liveSessionEloquent->saveGroups($request,$courseId);
    }

    public function updateCourseSchedule($id, $request)
    {

       return $this->liveSessionEloquent->updateCourseSchedule($id,$request);
    }

    public function publish($id)
    {
     return $this->liveSessionEloquent->publish($id);
    }

    public function createLiveSession($id,$is_web = true)
    {
      return $this->liveSessionEloquent->createLiveSession($id,$is_web);
    }

    function courseStudent($request,$is_web = true){

        $user = $this->getUser($is_web);

        $data = UserCourse::whereHas('course' , function($query) use($user){
            $query->where('user_id',$user->id);
        })->with('user');

        $course_id = $request->get('course_id');

        if($course_id != null){
            $data = $data->where('course_id',$course_id);
        }

        $data = $data->paginate(10);

        $data = new InCourseStudentCollection($data);

        return $data;
    }

    function courseUserAssignments($request , $is_web = true){

        $status = $request->get('status');
        $assignmentId = $request->get('assignment_id');
        $data = CourseAssignmentResults::where('course_id',$request->get('course_id'))
                ->when($status != null , function($query) use ($status){
                    $query->where('status' , $status);
                })
                ->when($assignmentId != null , function($query) use ($assignmentId){
                    $query->where('assignment_id',$assignmentId);
                })
                ->paginate(10);


        $data = new LecturerCourseUserAssignmentsCollection($data);

        return $data;



    }

    function courseAssignment($course_id){
        $data = CourseAssignments::active()->where('course_id',$course_id)->get();

        $data = LecturerCourseAssignmentsResource::collection($data);
        return $data;
    }

    function courseUserQuizzes($request , $is_web = true){

        $status = $request->get('status');
        $assignmentId = $request->get('quiz_id');
        $data = CourseQuizzesResults::where('course_id',$request->get('course_id'))
                ->when($status != null , function($query) use ($status){
                    $query->where('status' , $status);
                })
                ->when($assignmentId != null , function($query) use ($assignmentId){
                    $query->where('quiz_id',$assignmentId);
                })
                ->paginate(10);


        $data = new LecturerCourseUserQuizzesCollection($data);

        return $data;



    }

    function courseQuiz($course_id){
        $data = CourseQuizzes::active()->where('course_id',$course_id)->get();

        $data = LecturerCourseQuizResource::collection($data);
        return $data;
    }

    function previewUserQuiz($id){

        $quizResult = CourseQuizzesResults::find($id);
        $quiz = CourseQuizzes::where('id', $quizResult->quiz_id)
        ->with([
            'quizQuestions' => function ($query) use ($quizResult) {
                $query->with('quizzesQuestionsAnswers')
                ->with(['userAnswer' => function ($query) use ($quizResult){
                    $query->where('result_id',$quizResult->id);
                }]);
            },
            ])
            ->with('course')
            ->first();

        $questionCount = 0;
        $correctCount = 0;
        foreach($quiz->quizQuestions as $quest){
            $questionCount+=1;
            foreach($quest->quizzesQuestionsAnswers as $ans){
                if($ans->correct == 1){
                    if($quest->type == 'multiple'){

                        if($quest->userAnswer && $ans->id == $quest->userAnswer->answer_id)$correctCount+=1;
                    }else{
                        $anss = CourseQuizzesQuestionsAnswerTranslation::where('course_quizzes_questions_answer_id',$ans->id)->get();
                        foreach($anss as $ansL){
                            if($quest->userAnswer && $ansL->title == $quest->userAnswer->text_answer){
                                $correctCount+=1;
                                break;
                            }
                        }
                    }
                }
            }
        }
        $data['user_grade'] = $quizResult->user_grade;
        $data['grade'] = $quiz->grade;
        $data['status'] = $quizResult->status;
        $quiz = ShowResultQuestionResource::collection($quiz->quizQuestions);
        $data['question'] = $quiz;
        $data['questionCount'] = $questionCount;
        $data['correctCount'] = $correctCount;
        return $data;
    }

    function getStudentAnswer($result_id,$is_web = true){


        $result = CourseAssignmentResults::find($result_id);
        $assignment = $result->assignment()->with(['assignmentQuestions.userAnswers' => function($query) use ($result_id){
            $query->where('result_id',$result_id);
        }])->first();
        $question = $assignment->assignmentQuestions;

        $data = LecturerCourseUserAssignmentAnswerResource::collection($question);


        return $data;

    }

    function submitMark($request , $is_web = true){

        $mark = $request->get('mark');
        $result_id = $request->get('result_id');
        $question_id = $request->get('question_id');
        CourseAssignmentsResultsAnswer::updateOrCreate(['result_id' => $result_id , 'question_id' => $question_id] , ['mark' => $mark]);


    }

    function submitResult($request,$is_web = true){

        $result_id = $request->get('result_id');
        $result = CourseAssignmentResults::find($result_id);

        $mark = CourseAssignmentsResultsAnswer::where('result_id',$result_id)->whereNotNull('mark')->sum('mark');

        if($mark > $result->assignment->grad){
            return [
                'status' => false,
                'message' => __('the_mark_is_greater_than_the_full_mark')
            ];
        }

        if($mark >= $result->assignment->pass_grade){
            $status = 'passed';
        }else{
            $status = 'not_passed';
        }

        $result->grade = $mark;
        $result->status = $status;
        $result->save();


        return [
            'status' => true,
            'message' => __('message.operation_accomplished_successfully')
        ];

    }

    function getMyCategories($request , $is_web = true){
        $user = $this->getUser($is_web);
        $data = Category::where('parent','joining_course')
            ->whereHas('courses', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->paginate(10);

        return GetTeacherMyCategoriesResource::collection($data);

    }

    function getStudentHomeworks($course_id,$student_id,$is_web = true){
        $data = CourseAssignmentResults::where('course_id',$course_id)->where('student_id',$student_id)
        ->with('assignment')->paginate(10);

        $data = new TeacherStudentHomeworksCollection($data);
        return $data;
    }

    function showQuiz($quizId){
        $quiz = CourseQuizzes::where('id', $quizId)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->first();

        $data =   ShowQuizResource::collection($quiz->quizQuestions);
        return $data;
    }

    function showAssignment($assignmentId){
        $assignment = CourseAssignments::where('id', $assignmentId)
            ->with('assignmentQuestions', 'course')
            ->first();


        $data = ShowAssignmentResource::collection($assignment->assignmentQuestions);

        return $data;
    }

}
