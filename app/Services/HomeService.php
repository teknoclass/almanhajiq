<?php

namespace App\Services;

use App\Models\User;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Category;
use App\Models\CourseSession;
use App\Models\PrivateLessons;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TeacherCalendarCourseSessionResource;
use App\Http\Resources\TeacherCalendarPrivateLessonResource;
use Illuminate\Database\Eloquent\Builder;


class HomeService extends MainService
{
    public function allGradeLevels()
    {

        $gradeLevels = Category::where('key', 'grade_levels')->with('gradeLevels')->get();

        $materials = Category::getCategoriesByParent('course_categories')->get();
        $gradeLevels->each(function($gradeLevel) use ($materials) {
            $gradeLevel->materials = $materials;
        });
        return $this->createResponse(
            __('message.success'),
            true,
            $gradeLevels
        );

    }

    public function mostOrderedCourses(): array
    {
        $courses = Courses::active()->accepted()->withCount('students')->with([
            'grade_sub_level',
            'category',
            'lecturer',
            'priceDetails',
            'material'
        ])->orderBy('students_count', 'desc')->take(5)->get();

        return $this->createResponse(
            __('message.success'),
            true,
            $courses
        );
    }
    function lastCourses(){
        $courses = Courses::active()->accepted()->with([
            'grade_sub_level',
            'category',
            'lecturer',
            'priceDetails',
            'material'
            ])->take(5)->get();

            return $this->createResponse(
                __('message.success'),
                true,
                $courses
            );
    }

    public function topTeachers()
    {
        $topTeachers = User::whereHas('reviews', function($query) {
            $query->where('sourse_type', Ratings::USER)
                  ->active();
        })
                           ->withCount([
                               'ratings as ratings_sum' => function($query) {
                                   $query->where('sourse_type', Ratings::USER)
                                         ->active()
                                         ->select(DB::raw('sum(rate)'));
                               },
                               'ratings as ratings_count' => function($query) {
                                   $query->where('sourse_type', Ratings::USER)
                                         ->active()
                                         ->select(DB::raw('count(rate)'));
                               }
                           ])
                           ->with(['LecturerSetting', 'motherLang', 'ratings'])
                           ->having('ratings_count', '>', 0)
                           ->orderBy(DB::raw('ratings_sum / ratings_count'), 'desc')
                           ->get();

        return $this->createResponse(
            __('message.success'),
            true,
            $topTeachers
        );
    }

    // xx
    function SonsStatistics()
    {
        $user = auth()->user();
        $childs = $user->childs;
        // $sons_ids = $sons->pluck('son_id')->toArray();

        $data = [];
        foreach ($childs as $key => $child) {
            $data[] = [
                "courses"                  => $child->courses->count(),
                "courses_acheived"         => $child->courses->count(),
                "live_lessons"             => $child->liveCourseCount(),
                "live_lessons_acheived"    => $child->liveCourseCount(),
                "private_lessons_count"    => $child->privateLessonsCount(),
                "private_lessons_acheived" => $child->privateLessonsCount(),
            ];
        }

        return $data;
    }

    function calendar($request,$is_web = false){

        $ids = Courses::withTrashed()->active()->accepted()
        ->where(function($query) {
            $query->where('id',studentSubscriptionCoursessIds('api'));
            $query->orWhere('id',studentInstallmentsCoursessIds('api'));

            $query->orWhereHas('students', function (Builder $query) {
                $query->where('user_id', auth('api')->id())
                ->where(function ($query) {
                    $query ->where('is_complete_payment', 1)
                    ->orWhere('is_free_trial', 1);
                });
            });
        })->where('type', Courses::LIVE)->pluck('id');


        $date_now = now()->toDateString();

        $courseSessionDates = CourseSession::whereIn('course_id',$ids)
        ->where('date','>=',$date_now)->distinct()->pluck('date');

        $privateLessonDates = PrivateLessons::where('student_id',auth('api')->id())
        ->where('meeting_date','>=',$date_now)->distinct()->pluck('meeting_date');

        $mergedArray = array_merge($courseSessionDates->toArray(), $privateLessonDates->toArray());
        $uniqueDates = array_unique($mergedArray);
        sort($uniqueDates);


        if($request->get('date')){
            $date = $request->get('date');
        }else{
            $date = $date_now;
        }

        $courseSession = CourseSession::whereHas('course',function($q){
            $q->where('user_id',auth('api')->id());
        })->where('date','=',$date)->get();

        $privateLessons = PrivateLessons::where('teacher_id',auth('api')->id())
        ->where('meeting_date','=',$date)->get();

        $courseSession = TeacherCalendarCourseSessionResource::collection($courseSession);
        $privateLessons = TeacherCalendarPrivateLessonResource::collection($privateLessons);


        return [
            'dates' => $uniqueDates,
            'sessions' => $courseSession,
            'lessons' => $privateLessons
        ];


    }

    function featuredCourses(){
        $courses = Courses::active()->accepted()->with([
            'grade_sub_level',
            'category',
            'lecturer',
            'priceDetails',
            'material'
        ])->where('is_feature' , 1)->paginate(10);

        return $this->createResponse(
            __('message.success'),
            true,
            $courses
        );
    }





}
