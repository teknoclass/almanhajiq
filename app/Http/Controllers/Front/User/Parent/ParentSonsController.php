<?php

namespace App\Http\Controllers\Front\User\Parent;

use App\Http\Controllers\Controller;
use App\Models\CourseAssignments;
use App\Models\CourseLessons;
use App\Models\CourseQuizzes;
use App\Models\Courses;
use App\Models\ParentSon;
use App\Models\User;
use App\Models\{CourseQuizzesResults,UserCourse};
use App\Models\CourseAssignmentResults;
use App\Repositories\Front\User\AssignmentsEloquent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use DB;

class ParentSonsController extends Controller
{

    public function courses($son_id)
    {
        $data['son'] = ParentSon::where('son_id', $son_id)->first();

        $type = "web";

        $user_id = $son_id;

        $only_is_end = $use_filters = false;

        $data['courses'] = Courses::withTrashed()->active()->accepted()
            ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id',
            'level_id','grade_level_id','grade_sub_level','end_date','user_id')
            ->with('translations:courses_id,title,locale,description')
            ->with(['category' => function ($query) {
                $query->select('id', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            }
             ])
             ->with(['material' => function ($query) {
                $query->select('id', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            }
             ])
        ->where(function($query)  use ($user_id, $only_is_end,$type) {
            $query->where('id',someStudentSubscriptionCoursessIds($user_id));
            $query->orWhere('id',someStudentInstallmentsCoursessIds($user_id));

            $query->orWhereHas('students', function (Builder $query) use ($user_id, $only_is_end) {
                $query->where('user_id', $user_id)
                ->where(function ($query) {
                    $query ->where('is_complete_payment', 1)
                    ->orWhere('is_free_trial', 1);
                })
                ->when($only_is_end, function ($q) {
                    return $q->where('is_end', '1');
                });
            });
        })

            // to show the ongoing courses at first
            ->selectSub('SELECT MAX(user_courses.is_end) FROM user_courses WHERE user_courses.course_id = courses.id', 'is_end')
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', $user_id)->limit(1),

                'is_rating' => UserCourse::select('is_rating')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', $user_id)->limit(1),
            ])
            ->withCount('items')
            ->orderBy('is_end', 'asc')
            ->orderBy('id', 'desc');

        if ($use_filters) {
            if ($course_type == '' || $course_type == Courses::RECORDED) {
                $data['courses'] = $data['courses']->where('type', Courses::RECORDED);
            } else {
                $data['courses'] = $data['courses']->where('type', Courses::LIVE);
            }
        }

        $data['courses_count'] = $data['courses']->count();

        $data['courses'] = $data['courses']->get();

        return view('front.user.parent.sons-courses.index',$data);
    }

    public function courseDetails($course_id,$son_id)
    {
        $user_id = $son_id;

        $data['course'] = $this->getCourse($course_id,$user_id);
        $data['son'] = ParentSon::where('son_id', $son_id)->first();

        if ($data['course'] == '')
            abort(404);

        $course_id= $course_id;

        $data['completed_lessons'] = CourseLessons::where('course_id',$course_id)

        ->whereHas('learningStatus', function (Builder $query) use ($user_id) {
            $query->where('user_id',$user_id);
        })->get();

        $data['uncompleted_lessons'] = CourseLessons::where('course_id',$course_id)

        ->WhereDoesntHave('learningStatus', function (Builder $query) use ($user_id) {
            $query->where('user_id',$user_id);
        })->get();

        // quizzes
        $data['completed_quizzes'] = CourseQuizzes::where('course_id',$course_id)
        ->whereHas('quizResults', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->where('status', '!=', CourseQuizzesResults::$waiting);
        })->get();

        $data['uncompleted_quizzes'] = CourseQuizzes::where('course_id',$course_id)
        ->whereDoesntHave('quizResults', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();

        //assignments

        $data['completed_assignments'] = CourseAssignments::where('course_id',$course_id)
        ->whereHas('assignmentResults', function ($query) use ($user_id) {
            $query->where('student_id', $user_id)
                ->where('status', '!=', CourseAssignmentResults::$notSubmitted);
        })->get();



        $data['uncompleted_assignments'] = CourseAssignments::where('course_id',$course_id)
        ->whereDoesntHave('assignmentResults', function ($query) use ($user_id) {
            $query->where('student_id', $user_id);
        })->get();

        $data['completed_lessons_count'] = count($data['completed_lessons']);
        $data['completed_quizzes_count'] = count($data['completed_quizzes']);
        $data['completed_assignments_count'] = count($data['completed_assignments']);
        $data['uncompleted_lessons_count'] = count($data['uncompleted_lessons']);
        $data['uncompleted_quizzes_count'] = count($data['uncompleted_quizzes']);
        $data['uncompleted_assignments_count'] = count($data['uncompleted_assignments']);

        return view('front.user.parent.sons-courses.details',$data);

    }

    public function getCourse($course_id,$user_id)
    {
        $course = Courses::withTrashed()->active()->accepted()
        ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id',
        'level_id','grade_level_id','grade_sub_level','end_date')
        ->with('translations:courses_id,title,locale,description')
        ->where('id', $course_id)
        ->addSelect([
            'is_end' => UserCourse::select('is_end')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', $user_id)->limit(1),

            'is_rating' => UserCourse::select('is_rating')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', $user_id)->limit(1),
        ])
        ->first();
        return $course;
    }

    public function addSon(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $mobile = $request->mobile;

            $son = User::where('mobile',$mobile)->where('role','student')->first();

            if(! $son)
            {
                $message = "هذا الطالب غير موجود";
                $status = false;

                return $this->response_api($status, $message);
            }

            $code_country = $son->code_country;

            $parentSon = ParentSon::where('parent_id',auth()->id())->where('son_id',$son->id)->where('status','confirmed')->first();
            if($parentSon)
            {
                $message = 'الطالب مربوط بك بالفعل';
                $status = false;
                return $this->response_api($status, $message);
            }
            $linkSon = ParentSon::updateOrCreate([
                'parent_id' => auth()->id(),
                'son_id' => $son->id,
            ],['status' => 'pending']);

            if($linkSon)
            {
                //send otp
                $code = substr(sprintf("%06d", mt_rand(1, 999999)), 0, 6);
                $linkSon->otp = $code;
                $linkSon->update();

                sendOtpToWhatsapp($code_country.$mobile,$code);

                $message = __('otp_sent');
                $status = true;
            }else{
                $message = _('message.unexpected_error');
                $status = false;
            }

            DB::commit(); 
            return $this->response_api($status, $message);
          
        }
        catch (\Exception $e)
        {
            DB::rollback(); 
            \Log::error($e->getMessage());
            \Log::error($e->getFile());
            \Log::error($e->getLine());
            return $this->response_api(false, 'حدث خطأ');
        }
    }

    public function makeActive(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $mobile = $request->mobile;
            $son = User::where('mobile',$mobile)->where('role','student')->first();
            if(! $son)
            {
                $message = "هذا الطالب غير موجود";
                $status = false;

                return $this->response_api($status, $message);
            }
            $parentSon = ParentSon::where('son_id',$son->id)->where('parent_id',auth()->id())->where('status','confirmed')->first();
            if($parentSon)
            {
                $message = 'الطالب مربوط بك بالفعل';
                $status = false;
                return $this->response_api($status, $message);
            }
            $parentSon = ParentSon::where('son_id',$son->id)->where('parent_id',auth()->id())->where('status','pending')->first();
            $otp = $request->otp;
            if($parentSon && $otp == $parentSon->otp)
            { 
                $parentSon->update(['status' => 'confirmed']);   
                
                $message = __('done_operation');
                $status = true;
            }else{
                $message = __('otp_not_valid');
                $status = false;
            }

            DB::commit(); 
            return $this->response_api($status, $message);
      
        }
        catch (\Exception $e)
        {
            DB::rollback(); 
            \Log::error($e->getMessage());
            \Log::error($e->getFile());
            \Log::error($e->getLine());
            return $this->response_api(false, 'حدث خطأ'.$e->getMessage());
        }
    }

}