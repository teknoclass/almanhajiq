<?php

namespace App\Repositories;

use App\Models\CourseCurriculum;
use App\Models\CourseQuizzes;
use App\Models\CourseQuizzesQuestion;
use App\Models\CourseQuizzesQuestionsAnswer;
use App\Models\CourseQuizzesQuestionsAnswerTranslation;
use App\Models\CourseQuizzesQuestionTranslation;
use App\Models\Courses;
use App\Models\CourseSectionItems;
use App\Services\ItemService;
use App\Traits\Transactional;
use Illuminate\Support\Facades\Log;

class QuizRepository extends BaseRepository
{
    use Transactional;

    public CourseQuizzes $courseQuizzes;

    public int $total_mark;
    public function __construct(CourseQuizzes $courseQuizzes)
    {
        $this->courseQuizzes = $courseQuizzes;
        $this->total_mark = 0;
    }

    public function addQuiz($request, $is_web = true): array
    {
        return $this->executeTransaction(function () use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);

            $default_lang = app()->getLocale();

            for ($i = 1; $i <= count($request->{'questions_' . $default_lang}); $i++) {
                $complete = $request->{"question_{$i}_type"} == 'multiple' ? '' : 'complete_';
                if ($request->has($complete . "question_{$i}_mark") && !is_null($request->input($complete . "question_{$i}_mark"))) {
                    $this->total_mark += (double) $request->input($complete . "question_{$i}_mark");
                }
            }

            if ($this->total_mark != $data['grade']) {
                return $this->response(__('the_total_marks_of_the_questions_should_be_equal_to_the_exam_score'), false);
            }
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';

            $item = CourseQuizzes::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            $this->saveQuizQuestions($request, $item->id, $data['user_id']);


            ItemService::storeSectionItem($data, $item,CourseQuizzes::class);

            $this->notify_registered_users($request->course_id);

            return $this->response(__('message.operation_accomplished_successfully'), true);
        });
    }

    public function updateQuiz($request, $is_web = true): array
    {
        return $this->executeTransaction(function () use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);

            $default_lang = app()->getLocale();

            for ($i = 1; $i <= count($request->{'complete_questions_' . $default_lang}); $i++) {
                $complete = $request->{"question_{$i}_type"} == 'multiple' ? '' : 'complete_';
                if ($request->has($complete . "question_{$i}_mark") && !is_null($request->input($complete . "question_{$i}_mark"))) {
                    $this->total_mark += (double) $request->input($complete . "question_{$i}_mark");
                }
            }

            if ($this->total_mark != $data['grade']) {
                return $this->response(__('the_total_marks_of_the_questions_should_be_equal_to_the_exam_score'), false);
            }
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';

            $item = CourseQuizzes::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            CourseQuizzesQuestion::where(['course_quizzes_id' => $item->id])->delete();
            $this->saveQuizQuestions($request, $item->id, $data['user_id']);

            return $this->response(__('message.operation_accomplished_successfully'), true);
        });
    }

    public function deleteQuiz($request): array
    {
        return $this->executeTransaction(function () use ($request) {
            $item = CourseQuizzes::find($request->id);
            if ($item) {
                CourseSectionItems::where(['itemable_id' => $item->id])->delete();
                $item->delete();
                return $this->response(__('delete_done'), true);
            }

            return $this->response(__('message.item_not_found'), false);
        });
    }

    public function deleteOuterQuiz($request): array
    {
        return $this->executeTransaction(function () use ($request) {
            $item = CourseQuizzes::find($request->id);
            if ($item) {
                if (!$item->can_delete()) {
                    $item->status = 'inactive';
                    $item->save();
                    return $this->response(__('Cannot_Delete_any_of_course_Items_as_There_Students_already_subscribed') . __('just de-activated'), false);
                } else {
                    CourseCurriculum::where(['itemable_id' => $item->id])->delete();
                    $item->delete();
                    return $this->response(__('delete_done'), true);
                }
            }

            return $this->response(__('message.item_not_found'), false);
        });
    }

    private function saveQuizQuestions($request, $quizId, $userId)
    {
        $default_lang = app()->getLocale();
        for ($i = 0; $i < count($request->{'questions_' . $default_lang}); $i++) {
            $j = $i + 1;
            $complete = $request->{"question_{$j}_type"} == 'multiple' ? '' : 'complete_';
            if (!empty($request->{$complete . 'questions_' . $default_lang}[$i])) {
                $question = CourseQuizzesQuestion::create([
                    'course_quizzes_id' => $quizId,
                    'user_id' => $userId,
                    'grade' => $request->{$complete . 'question_' . ($i + 1) . '_mark'},
                    'type' => $request->{"question_{$j}_type"},
                ]);

                foreach (locales() as $locale => $value) {
                    CourseQuizzesQuestionTranslation::create([
                        'locale' => $locale,
                        'title' => $request->{$complete . 'questions_' . $locale}[$i],
                        'course_quizzes_question_id' => $question->id,
                    ]);
                }

                $answers = $request->{$complete . 'question_answers_' . $default_lang . '_' . ($i + 1)};
                for ($j = 0; $j < count($answers); $j++) {
                    $question_answer = CourseQuizzesQuestionsAnswer::create([
                        'question_id' => $question->id,
                        'user_id' => $userId,
                        'correct' => (isset($request->{'correct_answer_' . ($i + 1)}[$j]) && ($request->{'correct_answer_' . ($i + 1)}[$j])) ? 1 : 0,
                    ]);

                    foreach (locales() as $locale => $value) {
                        CourseQuizzesQuestionsAnswerTranslation::create([
                            'locale' => $locale,
                            'title' => @$request->{$complete . 'question_answers_' . $locale . '_' . ($i + 1)}[$j],
                            'course_quizzes_questions_answer_id' => $question_answer->id,
                        ]);
                    }
                }
            }
        }
    }

    public function getAll($request, mixed $is_web): mixed
    {
        $data = $request->all();
        $user = $this->getUser($is_web);

        if (!$user) {
            $course          = Courses::whereId($data['course_id'])->select('id', 'user_id')->first();
            $data['user_id'] = $course->user_id;
        }
        else {
            $data['user_id'] = $user->id;
        }
        $data['init_total_marks'] = 0;
        return $data;
    }
}
