<?php

namespace App\Services;

use App\Http\Requests\Api\FilterRequest;
use App\Models\Courses;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Log;

class CourseService extends MainService
{
    public function courseFilter(FilterRequest $filterRequest): array
    {
        $courses = Courses::active()
                          ->select(
                              'id',
                              'image',
                              'start_date',
                              'duration',
                              'type',
                              'category_id',
                              'is_active',
                              'user_id'
                          )
                          ->with('translations:courses_id,title,locale,description')
                          ->with([
                              'category' => function($query) {
                                  $query->select('id', 'value', 'parent')
                                        ->with('translations:category_id,name,locale');
                              }
                          ])
                          ->with('category')
                          ->addSelect([
                              'progress' => UserCourse::select('progress')
                                                      ->whereColumn('course_id', 'courses.id')
                                                      ->where('user_id', auth()->id())
                                                      ->limit(1)
                          ])
                          ->withCount('items')
                          ->orderBy('id', 'desc');

        try {
            $grade_sub_level = $filterRequest->grade_sub_level_id;

            if ($grade_sub_level) {

                $courses = $courses->filterByGradeSubLevel(json_decode($grade_sub_level));
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }


        if ($filterRequest->has('material_id')) {
            $courses = $courses->filterByCategories([$filterRequest->material_id]);
            $courses = $courses->with([
                'lecturers.lecturerSetting' => function($query) {
                    $query->select(
                        'id',
                        'user_id',
                        'video_thumbnail',
                        'video_type',
                        'video',
                        'exp_years',
                        'twitter',
                        'facebook',
                        'instagram',
                        'youtube'
                    )->with('translations:lecturer_setting_id,abstract,description,position,locale');
                }
            ]);
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $courses->get()
        );
    }

    public function mostOrderCourses(FilterRequest $filterRequest): array
    {
        $courses = Courses::withCount('students')
                          ->with([
                              'grade_sub_level',
                              'category',
                              'lecturer',
                              'priceDetails'
                          ])
                          ->where('grade_sub_level', $filterRequest->grade_sub_level_id);

        if ($filterRequest->has('material_id')) {
            $courses = $courses->filterByCategories([$filterRequest->material_id]);
        }

        $courses = $courses->orderBy('students_count', 'desc')->take(5);

        return $this->createResponse(
            __('message.success'),
            true,
            $courses->get()
        );

    }
}
