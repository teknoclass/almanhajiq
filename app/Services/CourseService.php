<?php

namespace App\Services;

use App\Models\Courses;
use App\Models\Category;
use App\Models\UserCourse;
use App\Models\CourseLessons;
use App\Models\CourseQuizzes;
use App\Models\Notifications;
use App\Models\CourseComments;
use App\Models\CourseLiveLesson;
use App\Models\CourseAssignments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\CourseRepository;
use App\Http\Requests\Api\FilterRequest;
use App\Models\CourseSessionSubscription;

class CourseService extends MainService
{
    public  CourseRepository $courseRepository;
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository= $courseRepository;
    }

    public function courseFilter($filterRequest , $is_paginate = false)
    {
        $courses = Courses::active()->accepted()
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
                if($filterRequest->has('from') || $filterRequest->has('to')){
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
        $courses = Courses::active()->accepted()->withCount('students')
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
                $exception->getMessage(),
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

    public function saveComment($request, $course_id, $is_web = true)
    {
        DB::beginTransaction();

        $user = getUser('api');

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

            if (!$course->isSubscriber('api')) {

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


}
