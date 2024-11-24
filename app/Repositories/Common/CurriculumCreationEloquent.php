<?php

namespace App\Repositories\Common;

use App\Models\CourseAssignments;
use App\Models\CourseLessons;
use App\Models\CourseQuizzes;
use App\Models\CourseSectionItems;
use App\Models\Notifications;
use App\Models\{CourseAssignmentQuestions,User,CourseAssignmentQuestionsTranslation,CourseCurriculum};
use App\Models\UserCourse;
use App\Repositories\AssignmentRepository;
use App\Repositories\Front\User\HelperEloquent;
use App\Repositories\LessonRepository;
use App\Repositories\QuizRepository;
use App\Repositories\SectionRepository;
use App\Strategies\ItemStrategyFactory;
use App\Traits\Transactional;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use DB;

class CurriculumCreationEloquent extends HelperEloquent
{

    public AssignmentRepository $assignmentRepository;
    public LessonRepository     $lessonRepository;
    public QuizRepository       $quizRepository;
    public SectionRepository    $sectionRepository;

    public function __construct(
        AssignmentRepository $assignmentRepository,
        LessonRepository     $lessonRepository,
        QuizRepository       $quizRepository,
        SectionRepository    $sectionRepository,
    )
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->lessonRepository     = $lessonRepository;
        $this->quizRepository       = $quizRepository;
        $this->sectionRepository    = $sectionRepository;
    }

    public function getModal($itemType): string
    {

        $strategy = ItemStrategyFactory::create(request()->query('item_id'),$itemType);

        $data = [
            'course_id' => request()->query('course_id'),
            'course_section_id' => request()->query('section_id'),
            'course_type' => request()->query('course_type'),
            'type' => request()->query('type'),
            'user_type' => $this->getUserType(),
        ];

        return $strategy->renderModal($data);
    }

    public function getUserType()
    {
        if (Str::contains(request()->url(), 'admin')) {
            return "admin";
        }
        else if (Str::contains(request()->url(), 'lecturer')) {
            return "lecturer";
        }
        return 'user_type_not_found';

    }

    private function renderModal(string $viewPath, array $data): string
    {
        return View::make($viewPath, $data)->render();
    }

    public function getCorrectModal(bool $is_web = true): string
    {
        return $this->getSolutionModal('task', CourseAssignments::class, 'assignmentQuestions', 'assignmentResults', 'assignment_id', [
            'correct' => 'front.user.lecturer.courses.my_courses.tasks.modals.correct',
        ]);
    }

    private function getSolutionModal(
        string $itemType,
        string $modelClass,
        string $questionsRelation,
        string $resultsRelation,
        string $foreignKey,
        array  $viewPaths
    ): string
    {
        $data = $this->prepareSolutionData();

        $data['student'] = User::select('id', 'name')->where('id', $data['student_id'])->first();

        $data['course_item'] = $modelClass::active()
                                          ->where('id', $data['item_id'])
                                          ->with($questionsRelation)
                                          ->with([$resultsRelation => function($query) use ($data, $foreignKey) {
                                              $query->where(['student_id' => $data['student_id'], $foreignKey => $data['item_id']]);
                                          }])
                                          ->withCount($questionsRelation)
                                          ->first();

        if ($data['course_item']->$resultsRelation) {
            $data['student_solutions'] = json_decode($data['course_item']->$resultsRelation[0]->results, true);
        }

        $viewPath = isset($viewPaths['correct']) ? $viewPaths['correct']: $viewPaths['solutions'];

        return $this->renderModal($viewPath, $data);
    }

    private function prepareSolutionData(): array
    {
        return [
            'item_id' => request()->query('item_id'),
            'student_id' => request()->query('student_id'),
            'course_id' => request()->query('course_id'),
        ];
    }

    public function getQuizSolutionModal(bool $is_web = true): string
    {
        return $this->getSolutionModal('exam', CourseQuizzes::class, 'quizQuestions', 'studentQuizResults', 'quiz_id', [
            'solutions' => 'front.user.lecturer.courses.my_courses.exams.modals.solutions',
        ]);
    }

    #[ArrayShape(['type' => "string", 'new_item' => "mixed", 'message' => "\mixed|string", 'status' => "bool"])]
    public function addSection($request, $is_web = true): array
    {

        return $this->sectionRepository->addSection($request, $is_web);
    }

    public function deleteSection($request): array
    {
        return $this->sectionRepository->deleteSection($request);
    }

    public function deleteCourseAttachment($request, $img_id): array
    {

        return $this->lessonRepository->deleteCourseAttachment($request, $img_id);
    }

    public function addLesson($request, $is_web = true): array
    {
        return $this->lessonRepository->addLesson($request, $is_web);
    }

    public function updateLesson($request, $is_web = true): array
    {

        return $this->lessonRepository->updateLesson($request, $is_web);

    }

    public function deleteLesson($request): array
    {

        return $this->lessonRepository->deleteLesson($request);
    }

    public function deleteOuterLesson($request): array
    {
        return $this->lessonRepository->deleteOuterLesson($request);
    }


    public function addQuiz($request, $is_web = true): array
    {
        return $this->quizRepository->addQuiz($request, $is_web);
    }

    public function updateQuiz($request, $is_web = true): array
    {
        return $this->quizRepository->updateQuiz($request, $is_web);
    }

    public function deleteQuiz($request): array
    {
        return $this->quizRepository->deleteQuiz($request);
    }

    public function deleteOuterQuiz($request): array
    {
        return $this->quizRepository->deleteOuterQuiz($request);
    }

    // public function addTask($request, $is_web = true): array
    // {
    //     return $this->assignmentRepository->addAssignment($request, $is_web);
    // }

    // public function updateTask($request, $is_web = true): array
    // {
    //     return $this->assignmentRepository->updateAssignment($request, $is_web);
    // }

    public function addTask($request, $is_web = true) {

        try {
            DB::beginTransaction();
            $data            = $request->all();
            $user            = $this->getUser($is_web);
            $default_lang = app()->getLocale();
            if (!$user) {
                $course = Courses::whereId($data['course_id'])->select('id', 'user_id')->first();
                $data['user_id'] = $course->user_id;
            } else {
                $data['user_id'] = $user->id;
            }

            $answers_array   = array_values($request->answer_type);
            $data['answer_type'] = $answers_array;
            (isset($data['status'])) ? $data['status'] = 'active' : $data['status'] = 'inactive';
            $item            = CourseAssignments::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            for($i = 0 ; $i < count($request->{'questions_' . $default_lang}) ; $i++) {
                if(!empty($request->{'questions_' . $default_lang}[$i])) {
                    $question  = CourseAssignmentQuestions::create([
                        'course_assignment_id'  => $item->id,
                        'user_id'               => $data['user_id'],
                        'type'                  => $data['answer_type'][$i] ?? 'text',
                    ]);
                    foreach (locales() as $locale => $value) {
                        $question_translation    = new CourseAssignmentQuestionsTranslation() ;
                        $question_translation->course_assignment_questions_id = $question->id;
                        $question_translation->locale  = $locale;
                        $question_translation->title   = $request->{'questions_' . $locale}[$i];;
                        $question_translation->save();
                    }
                }
            }

            if(isset($data['course_sections_id'])) {
                $section_item2     = CourseSectionItems::orderBy('id', 'DESC')->select('order')->first();
                if($section_item2) {
                    $order = $section_item2->order;
                } else {
                    $order = 0;
                }
                $section_item  = CourseSectionItems::create([
                    'course_id'             => $data['course_id'],
                    'course_sections_id'    => $data['course_sections_id'],
                    'itemable_id'               => $item->id,
                    'itemable_type'             => CourseAssignments::class,
                    'order'                 =>  $order + 1,
                ]);
            }else {
                $curriculum_item     = CourseCurriculum::orderBy('id', 'DESC')->select('order')->first();
                if($curriculum_item) {
                    $order = $curriculum_item->order;
                } else {
                    $order = 0;
                }
                $curriculum_itemm  = CourseCurriculum::create([
                    'course_id'     => $request->course_id,
                    'itemable_id'       => $item->id,
                    'itemable_type'     => CourseAssignments::class,
                    'order'         =>  $order + 1,
                ]);
            }
            DB::commit();

            $this->notify_registered_users($request->course_id);

            $message = __('message.operation_accomplished_successfully');
            $status = true;
            $response = [
                'message'  => $message,
                'status'   => $status,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;

    }

    public function updateTask($request, $is_web = true)
    {

        try {
            DB::beginTransaction();
            $data            = $request->all();
            $answers_array   = array_values($request->answer_type);
            $data['answer_type'] = $answers_array;
            $default_lang = app()->getLocale();

            $user            = $this->getUser($is_web);
            if (!$user) {
                $course = Courses::whereId($data['course_id'])->select('id', 'user_id')->first();
                $data['user_id'] = $course->user_id;
            } else {
                $data['user_id'] = $user->id;
            }

            (isset($data['status'])) ? $data['status'] = 'active' : $data['status'] = 'inactive';
            $item            = CourseAssignments::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            $existingQuestions = CourseAssignmentQuestions::where('course_assignment_id', $item->id)->get();
            $existingQuestionIds = $existingQuestions->pluck('id')->toArray();

            $sentQuestionIds = array_filter($request->input('question_ids', []));
            //questions to delete
            $questionsToDelete = array_diff($existingQuestionIds, $sentQuestionIds);
            CourseAssignmentQuestions::whereIn('id', $questionsToDelete)->delete();

            for ($z = 0; $z < count($request->{'questions_' . $default_lang}); $z++) {
                if (!empty($request->{'questions_' . $default_lang}[$z])) {
                    $questionId = $request->input('question_ids')[$z] ?? null;
                    //update question
                    if ($questionId && in_array($questionId, $existingQuestionIds)) {
                        $question = CourseAssignmentQuestions::find($questionId);
                        $question->type = $data['answer_type'][$z] ?? 'text';
                        $question->save();
                    } else {//add new question
                        $question = CourseAssignmentQuestions::create([
                            'course_assignment_id' => $item->id,
                            'user_id'              => $data['user_id'],
                            'type'                 => $data['answer_type'][$z] ?? 'text',
                        ]);
                    }

                    //translations
                    foreach (locales() as $locale => $value) {
                        $questionTranslation = CourseAssignmentQuestionsTranslation::updateOrCreate(
                            [
                                'course_assignment_questions_id' => $question->id,
                                'locale'                         => $locale,
                            ],
                            [
                                'title' => $request->{'questions_' . $locale}[$z],
                            ]
                        );
                    }
                }
            }

            DB::commit();
            $message = __('message.operation_accomplished_successfully');
            $status = true;
            $response = [
                'message'  => $message,
                'status'   => $status,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;

    }

    public function deleteTask($request): array
    {
        return $this->assignmentRepository->deleteAssignment($request);
    }

    public function deleteOuterTask($request): array
    {
        return $this->assignmentRepository->deleteOuterAssignment($request);
    }

    function notify_registered_users($course_id)
    {
        $user_courses = UserCourse::where('course_id', $course_id)->where('is_end', 1)->get();
        $course_title = $user_courses->first()?->course?->title;
        foreach ($user_courses as $key => $user_course) {
            // notify
            $title                       = 'إضافة محتوي للدورة';
            $text                        = " تم إضافة محتوي للدورة: " . $course_title;
            $notification['title']       = $title;
            $notification['text']        = $text;
            $notification['user_type']   = 'user';
            $notification['action_type'] = 'add_course_requests';
            $notification['action_id']   = $course_id;
            $notification['created_at']  = \Carbon\Carbon::now();

            $notification['user_id'] = $user_course->user_id;

            Notifications::insert($notification);
            sendWebNotification($user_course->user_id, 'user', $title, $text);

            return true;
        }

        UserCourse::where('course_id', $course_id)->where('is_end', 1)->update([
            "is_end" => 0
        ]);
    }

    public function getLessonModal($is_web = true)
    {
        $user_type = $this->getUserType();

        $data = [
            'course_id'             => request()->query('course_id'),
            'course_section_id'     => request()->query('section_id'),
            'type'                  => request()->query('type'),
            'user_type'             => @$user_type
        ];

        if ($data['type'] == 'add') {
            $content = View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.lessons.lesson', $data)->render();
        } else {
            $data['item']          =  CourseLessons::where('id', request()->query('item_id'))->with('translations:course_lessons_id,title,description,locale')->first();
            $data['attachments']   = $data['item']->attachments;
            $content = View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.lessons.edit_lesson', $data)->render();
        }

        return $content;
    }

}
