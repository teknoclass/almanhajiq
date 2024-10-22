<?php

namespace App\Strategies;

use App\Models\CourseQuizzes;
use App\Models\CourseQuizzesResults;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class QuizStrategy implements ItemStrategy
{
    protected ?int $quizId;

    public function __construct(?int $quizId)
    {
        $this->quizId = $quizId;
    }


    public function isCompleted(): bool
    {
        return CourseQuizzesResults::where([
            'quiz_id' => $this->quizId,
            'user_id' => Auth::id(),
        ])->where('status', '!=', CourseQuizzesResults::$waiting)->exists();
    }
    public function renderModal(array $data): string
    {
        if ($data['type'] == 'add') {
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.exam', $data)->render();
        } else {
            $data['item'] = CourseQuizzes::where('id', $this->quizId)
                                         ->with(['quizQuestions.quizzesQuestionsAnswers', 'translations:course_quizzes_id,title,description,locale'])
                                         ->first();
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.exam', $data)->render();
        }
    }
    public function getModelClass(): string
    {
        return CourseQuizzes::class;
    }

    public function applyCompletedScope($query)
    {
        $query->whereHas('quizResults', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', '!=', CourseQuizzesResults::$waiting);
        });
    }
}
