<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $courses = Courses::withCount('students')->with([
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
            $courses = Courses::active()->with([
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



}
