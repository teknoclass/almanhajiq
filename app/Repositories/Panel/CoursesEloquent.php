<?php

namespace App\Repositories\Panel;

use App\Http\Resources\CoursesResources;
use App\Models\Category;
use App\Models\CertificateTemplates;
use App\Models\CourseContentDetails;
use App\Models\CourseFaqs;
use App\Models\CourseLecturers;
use App\Models\CoursePriceDetails;
use App\Models\CourseRequirements;
use App\Models\Courses;
use App\Models\CourseSections;
use App\Models\CourseSession;
use App\Models\CourseSessionsGroup;
use App\Models\CourseSuggestedDates;
use App\Models\Faqs;
use App\Models\PagesText;
use App\Models\UserCourse;
use App\Repositories\Common\LiveSessionEloquent;
use Carbon\Carbon;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Termwind\ValueObjects\pr;

class CoursesEloquent
{
    public LiveSessionEloquent $liveSessionEloquent ;
    public function __construct(LiveSessionEloquent $liveSessionEloquent)
    {
        $this->liveSessionEloquent = $liveSessionEloquent;
    }

    public function getDataTable()
    {

        $data = Courses::select('id', 'category_id', 'user_id', 'status','material_id')
                       ->with('translations:courses_id,title,locale')
                       ->with('category')
                       ->with('lecturer')
                       ->with('material')
                       ->withCount('students')
                       ->orderByDesc('created_at')->get();

        return Datatables::of($data)
                         ->addIndexColumn()
                         ->addColumn('rating', 'panel.courses.partials.ratings')
                         ->addColumn('comments', 'panel.courses.partials.comments')
                         ->addColumn('students', 'panel.courses.partials.students')
                         ->addColumn('action', 'panel.courses.partials.actions')
                         ->rawColumns(['action', 'rating', 'comments', 'students'])
                         ->make(true);

    }

    public function store($request)
    {
        DB::beginTransaction();

        $redirect_url = null;
        try {
            $data = $request->all();
            if ($request->get('start_date')) {
                $data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            }
            $data['grade_level_id'] = $request->grade_level_id;
            $data['grade_sub_level'] = $request->grade_sub_level;
            $course = Courses::updateOrCreate(['id' => 0], $data)->createTranslation($request);


            // save lecturers
            //    $this->saveLecturers($course->id, $request->lecturer_id);


            $message      = __('message_done');
            $status       = true;
            $redirect_url = url('admin/courses/edit/base-information/' . $course->id);

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
            'redirect_url' => $redirect_url,
        ];

        return $response;
    }

    public function edit($id)
    {
        $data = $this->create();

        $data['item'] = Courses::where('id', $id)
                               ->with(['lecturers:id,name'])
                               ->with(['groups.sessions'])
                               ->first();

        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function create()
    {
        $data['languages'] = Category::query()->select('id', 'value', 'parent')
                                     ->with('translations:category_id,name,locale')
                                     ->where('parent', 'course_languages')
                                     ->orderByDesc('created_at')->get();

        $data['levels'] = Category::query()->select('id', 'value', 'parent')
                                  ->with('translations:category_id,name,locale')
                                  ->where('parent', 'course_levels')
                                  ->orderByDesc('created_at')->get();

        $data['grade_levels']      = Category::where('key', 'grade_levels')->orderBy('order','asc')->get();
        $data['grade_children_levels']      = Category::where('parent', 'grade_levels')->get();

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

    public function saveLecturers($course_id, $lecturer_ids)
    {
        CourseLecturers::where('course_id', $course_id)->delete();
        $lecturer_ids_array = array($lecturer_ids);
        $lecturers          = [];
        if (count($lecturer_ids_array) > 0) {
            foreach ($lecturer_ids_array as $lecturer_id) {
                $lecturers[] = [
                    'course_id' => $course_id,
                    'user_id' => $lecturer_id,
                    'created_at' => Carbon::now()
                ];
            }

            CourseLecturers::insert($lecturers);
        }

        return true;
    }

    public function delete($id)
    {
        $item = Courses::find($id);
        // $is_couse_subscribed = $item->students?->where('is_paid' , 1 )->where('progress' , '>=' , 0)->count();
        // if($is_couse_subscribed){
        //     $message = __('Cannot Delete any of course Items as There`re Students already subscribed.');
        //     $status = false;
        //     return [
        //         'message' => $message,
        //         'status' => $status,
        //     ];
        // }
        if ($item) {

            $item['is_delete'] = 1;
            $item->update();

            $ch_count_student = UserCourse::where('course_id', $id)->count();
            if ($ch_count_student == 0) {
                $item->delete();
                $message  = __('delete_done');
                $status   = true;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }
            else {
                $item->delete();
                $message = __('delete_course_error');
                $status  = true;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }

        }
        $message = __('message_error');
        $status  = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();


        try {
            $data = $request->all();

            if ($request->get('start_date')) {
                $data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            }
            $data['grade_level'] = $request->grade_level_id;
            $data['grade_sub_level'] = $request->grade_sub_level;
            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);

            // save levels

            // save lecturers
            //  $this->saveLecturers($course->id, $request->lecturer_id);

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function deleteVideo($id)
    {
        $item = Courses::find($id);
        if ($item) {
            $item->video = '';
            $item->update();
            $message  = __('delete_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
        $message = __('message_error');
        $status  = false;

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
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function editContentDetails($id, $type)
    {
        $data['item'] = Courses::where('id', $id)
                               ->with(array('contentDetails' => function($query) use ($type) {
                                   $query->where('type', $type);
                               }))
                               ->first();

        if ($data['item'] == '') {
            abort(404);
        }
        $data['title'] = __($type);
        $data['type']  = $type;

        return $data;
    }

    public function updateContentDetails($id, $type, $request)
    {
        DB::beginTransaction();

        try {
            $data            = $request->all();
            $content_details = $request->content_details;

            //delete CourseContentDetails
            //CourseContentDetails::where('course_id', $id)->delete();
            $delete_item = array(0);

            if (isset($content_details)) {
                foreach ($content_details as $course_content_details) {
                    $request_content_details = new Request();
                    foreach (array_keys($course_content_details) as $key) {
                        $request_content_details->request->add([$key => $course_content_details[$key]]);
                    }

                    if (isset($course_content_details['icon'])) {
                        $custome_path                     = 'courses/' . $id . '/content_details';
                        $content_details_icon             = $custome_path . '/' . uploadFile($course_content_details['icon'], $custome_path);
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


            CourseContentDetails::where('course_id', $id)->
            where('type', $type)->whereNotIn('id', $delete_item)
                                ->delete();
            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
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
        $data['item']    = Courses::where('id', $id)
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
            $data     = $request->all();
            $sections = $request->sections;

            $delete_item = array(0);

            if (isset($sections)) {
                foreach ($sections as $course_section) {
                    $request_content_details = new Request();


                    $request_content_details['course_id']             = $id;
                    $request_content_details['course_requirement_id'] = $course_section['course_requirement_id'];
                    $section_id                                       = 0;
                    if (isset($course_section['id'])) {
                        $section_id = $course_section['id'];
                        array_push($delete_item, $section_id);
                    }

                    $item = CourseRequirements::updateOrCreate(['id' => $section_id,], $request_content_details->all());
                    array_push($delete_item, $item->id);
                }
            }


            CourseRequirements::where('course_id', $id)
                              ->whereNotIn('id', $delete_item)
                              ->delete();

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('course_request_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editSections($id)
    {
        $data['item'] = Courses::where('id', $id)
                               ->with('sections')
                               ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function updateSections($id, $request)
    {
        DB::beginTransaction();

        try {
            $data     = $request->all();
            $sections = $request->sections;

            $delete_item = array(0);

            if (isset($sections)) {
                foreach ($sections as $course_section) {
                    $request_content_details = new Request();
                    foreach (array_keys($course_section) as $key) {
                        $request_content_details->request->add([$key => $course_section[$key]]);
                    }
                    if (!isset($course_section['is_active'])) {
                        $is_active                            = 0;
                        $request_content_details['is_active'] = 0;
                    }
                    else {
                        $is_active                            = 1;
                        $request_content_details['is_active'] = 1;
                    }
                    $request_content_details['course_id'] = $id;

                    $section_id = 0;
                    if (isset($course_section['id'])) {
                        $section_id = $course_section['id'];
                        array_push($delete_item, $section_id);
                    }

                    $item = CourseSections::updateOrCreate(['id' => $section_id,], $request_content_details->all())->createTranslation($request_content_details);
                    array_push($delete_item, $item->id);
                }
            }


            CourseSections::where('course_id', $id)
                          ->whereNotIn('id', $delete_item)
                          ->delete();

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = $e->getMessage();//__('message_error');
            $status  = false;
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
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
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

        $data['certificate_templates']                     = CertificateTemplates::
        where('course_category_id', @$data['item']->material?->value ?? null)
                                                                                 ->orWhereNull('course_category_id')
                                                                                 ->get();
        $data['introductory_text_for_course_registration'] = $data['item'];

        return $data;
    }

    public function updateWelcomeTextForRegistration($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editForWhomThisCourse($id)
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

    public function updateForWhomThisCourse($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = $e->getMessage();// __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function editWhatWillYouLearnFromThisCourse($id)
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

    public function updateWhatWillYouLearnFromThisCourse($id, $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $course = Courses::updateOrCreate(['id' => $id], $data)->createTranslation($request);

            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = $e->getMessage();// __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
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

                $suggested_date_id  = $suggested_date['suggested_date_id'];
                $data['course_id']  = $id;
                $data['date']       = $suggested_date['start_date'] . ' ' . $suggested_date['start_time'];
                $data['start_date'] = $suggested_date['start_date'];
                $data['start_time'] = $suggested_date['start_time'];
                $data['is_active']  = $suggested_date['is_active'];

                //Check for scheduling conflicts
                $item = CourseSuggestedDates::where('course_id', $id)
                                            ->where('date', $data['date'])
                                            ->where('id', '!=', $suggested_date_id)
                                            ->first();

                if ($item) {
                    $lecturer_name = $item->lecturer->name;
                    $date          = $item->date;
                    $course_title  = $item->course->title;
                    if ($item->course_id == $id) {
                        $message = " $lecturer_name لديه تعارض بالموعد $date";
                    }
                    else {
                        $message = " $lecturer_name لديه تعارض بالموعد $date بدورة $course_title ";
                    }
                    $status   = false;
                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;

                }


                CourseSuggestedDates::updateOrCreate(['id' => $suggested_date_id], $data);

            }


            $message = __('message_done');
            $status  = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    // public function editCurriculum($id)
    // {
    //     $data['item'] = Courses::where('id', $id)
    //         ->with('sections')
    //         ->first();
    //     if ($data['item'] == '') {
    //         abort(404);
    //     }
    //     return $data;
    // }

    public function editCurriculum($id, $is_web = true)
    {
        //  $data['user']            = $this->getUser($is_web);
        $data['course']         = Courses::find($id);
        $data['course_sections'] = Courses::with([
            'items.sections' => function($query) {
                $query->with('items.itemable');
            },
        ], 'items.itemable')->where('id', $id)->first();
        $data['item_types'] = config('constants.item_types');
        return $data;
    }

    public function waitingEvaluation($id, $is_web = true)
    {
        // $data['user']  = $this->getUser($is_web);

        $data['item'] = Courses::find($id);

        if (!$data['item']) abort(404);

        return $data;
    }

    public function unacceptedEvaluation($id, $is_web = true)
    {
        //$data['user']   = $this->getUser($is_web);

        $data['item'] = Courses::find($id);

        if (!$data['item']) abort(404);

        $data['evaluation'] = AddCourseRequests::where('courses_id', $id)->orderBy('id', 'desc')->first();

        if (!$data['evaluation']) abort(404);

        return $data;
    }

    public function search($type, $request)
    {

        $search = $request->get('search');

        $courses = Courses::select('id')->where(function(Builder $query) use ($search) {
            $query->whereHas('translations', function($q) use ($search) {
                return $q->where('title', 'like', '%' . $search . '%');
            });
        })
                          ->with('translations:courses_id,title,locale')
            //->where('type', $type)
                          ->take(10)->get();


        $items = CoursesResources::collection($courses);

        $response = ['status' => true, 'message' => 'done', 'items' => $items];


        return response()->json($response);

    }

    public function getLecturers($request)
    {

        $lecturers = $this->getLecturersData($request);

        $options = "<select class='form-control w-100'   data-size='4' data-live-search='true'
         name='lecturer_id'
        required
        data-style='bg-transparent'>";

        foreach ($lecturers as $lecturer) {
            $options = $options . '<option value="' . @$lecturer->user_id . '" >' . @$lecturer->user->name . '</option>';
        }

        $options = $options . '</select>';

        return $options;

    }


    public function getLecturersData($request)
    {

        $course_id = $request->course_id;

        $lecturers = CourseLecturers::where('course_id', $course_id)->get();

        return $lecturers;

    }


    public function getLevels($request)
    {

        $levels = $this->getLevelsData($request);

        $options = "<select class='form-control w-100'   data-size='4' data-live-search='true'
         name='level_id'
        required
        data-style='bg-transparent'>";

        foreach ($levels as $level) {
            $options = $options . '<option value="' . @$level->level_id . '" >' . @$level->level->name . '</option>';
        }

        $options = $options . '</select>';

        return $options;

    }


    public function getLevelsData($request)
    {

        $course_id = $request->course_id;

        $levels = CourseLevels::where('course_id', $course_id)->get();

        return $levels;

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

    public function createLiveSession($id)
    {
        return $this->liveSessionEloquent->createLiveSession($id);
    }


}
