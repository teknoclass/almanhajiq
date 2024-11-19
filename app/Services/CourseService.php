<?php

namespace App\Services;

use App\Http\Requests\Api\FilterRequest;
use App\Models\Category;
use App\Models\Courses;
use App\Models\CourseSessionSubscription;
use App\Models\UserCourse;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseService extends MainService
{
    public  CourseRepository $courseRepository;
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository= $courseRepository;
    }

    public function courseFilter($filterRequest , $is_paginate = false): array
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

        if($filterRequest->has('type')){
            $courses = $courses->filterByType($filterRequest->type);
        }

        if($filterRequest->has('priceType')){
            if($filterRequest->priceType == "free"){
                $courses = $courses->free();
            }else{
                if($filterRequest->has('from') && $filterRequest->has('to')){
                    $courses = $courses->filterByPriceRange($filterRequest->from ,$filterRequest->to );
                }else{
                    $courses = $courses->paid();
                }
            }
        }

        if($filterRequest->has('title')){
            $courses = $courses->filterByTitle($filterRequest->title);
        }
        if($is_paginate){
            $data = $courses->paginate(10);
        }else{
            $data = $courses->get();
        }
        return $this->createResponse(
            __('message.success'),
            true,
            $data
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

    public function getById($id){
        try {
            $course = $this->courseRepository->findByIdWith($id,count:[
                'students',
                'groups as groups_count' => function($query) {
                    $query->select(DB::raw('COUNT(DISTINCT group_id)'));
                },
                'sessions']);

            if ($course) {
                $course->groups = $course->groups->unique('id');
            }
            return $this->createResponse(
                __('message.success'),
                true,
                $course
            );
        }

        catch (\Exception  $exception){
            Log::error($exception->getMessage());
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

    }


    public function getCourseByUserId($request,$id){
        try {
            $user = $request->attributes->get('user');

            $isSub = $this->courseRepository->getCourseByUserId($user,$id)?->course;
            $course = $this->courseRepository->findById($id);
            if ($course){
                $course->setAttribute('is_sub', (int)!is_null($isSub));
            }

            if (!$course) {
                return $this->createResponse(
                    __('message.not_found'),
                    false,
                    null
                );
            }
            return $this->createResponse(
                __('message.success'),
                true,
                $course
            );
        }
        catch (\Exception  $exception){
            Log::error($exception->getMessage());
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

    }

}
