<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\QuizEloquent;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    private $quiz;

    public function __construct(QuizEloquent $quiz_eloquent)
    {
        $this->quiz = $quiz_eloquent;
    }

    public function start(Request $request, $course_id, $id)
    {
        $data = $this->quiz->start($request, $course_id, $id);

        if (@$data['error'] == 'quiz_done')
            return back()->with('message', "Quiz can't be started");

        if (@$data['error'] == 'quiz_time_passed')
            return redirect()->route('user.courses.curriculum.openByItem', ['course_id' => $data['course_id'], 'type' => 'quiz', 'id' => $data['quiz_id']]);

        return view('front.user.courses.curriculum.quizzes.content', $data);
    }

    public function storeResult(Request $request, $course_id, $id)
    {
        $data = $this->quiz->storeResult($request, $course_id, $id);

        return redirect()->route('user.courses.curriculum.openByItem', ['course_id' => $data['course_id'], 'type' => 'quiz', 'id' => $data['quiz_id']]);
    }

}
