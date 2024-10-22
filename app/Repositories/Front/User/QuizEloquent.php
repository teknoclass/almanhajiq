<?php

namespace App\Repositories\Front\User;

use App\Models\CourseQuizzes;
use App\Models\CourseQuizzesQuestion;
use App\Models\CourseQuizzesQuestionsAnswer;
use App\Models\CourseQuizzesResults;
use App\Models\Notifications;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class QuizEloquent extends HelperEloquent
{

    public function start($request, $course_id, $id)
    {
        $quiz = CourseQuizzes::where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->with('course')
            ->first();

        $user = auth()->user();

        if ($quiz) {
            // Does the user started the quiz
            $userQuizSolution = CourseQuizzesResults::where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->first();

            // The user didn't start one before so start one
            if (!$userQuizSolution) {
                $quizResult = CourseQuizzesResults::create([
                    'course_id' => $quiz->course->id,
                    'quiz_id' => $quiz->id,
                    'user_id' => $user->id,
                    'results' => '',
                    'user_grade' => 0,
                    'status' => CourseQuizzesResults::$waiting,
                    'started_at' => now(),
                    'created_at' => now(),
                ]);

                $data = [
                    'quiz' => $quiz,
                    'quizQuestions' => $quiz->quizQuestions,
                    'quizResult' => $quizResult
                ];

                return $data;
            }
            // The user started one before
            else
            {
                // Check if the user submitted his solution
                if ($userQuizSolution->status == CourseQuizzesResults::$waiting) {
                    $now = Carbon::now();
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $userQuizSolution->started_at)->addMinutes($quiz->time);

                    $is_passed_time = $now > $end_time;

                    // If the user didn't submit the solution and he still has time
                    if (!$is_passed_time) {

                        $diffInSeconds = $end_time->diffInSeconds($now);
                        $quiz->time = $diffInSeconds / 60;

                        $data = [
                            'quiz' => $quiz,
                            'quizQuestions' => $quiz->quizQuestions,
                            'quizResult' => $userQuizSolution
                        ];

                        return $data;
                    }
                    // If the user didn't submit the solution and he Doesn't have time
                    else
                    {
                        // Set the user as failed and close the solution attemption
                        $userQuizSolution->update([
                            'results' => '',
                            'user_grade' => 0,
                            'status' => CourseQuizzesResults::$failed,
                            'created_at' => now()
                        ]);

                        // update the progress
                        $course = $quiz->course;
                        $course->updateProgress();

                        $data['error']      = 'quiz_time_passed';
                        $data['quiz_id']    = $quiz->id;
                        $data['course_id']  = $quiz->course_id;

                        return $data;
                    }
                }
                else {
                    $data['error'] = 'quiz_done';
                    return $data;
                }
            }
        }
        abort(404);
    }

    public function storeResult($request, $course_id, $id)
    {
        $user = auth()->user();
        $quiz = CourseQuizzes::where('id', $id)->with('course')->first();

        if ($quiz) {
            $results = $request->get('question');
            $quizResultId = $request->get('quiz_result_id');

            if (!empty($quizResultId)) {

                $quizResult = CourseQuizzesResults::where('id', $quizResultId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!empty($quizResult)) {

                    $passMark = $quiz->pass_mark;
                    $totalMark = 0;
                    $status = '';

                    $now = Carbon::now();
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $quizResult->started_at)->addMinutes($quiz->time);

                    $is_passed_time = $now > $end_time;

                    if (empty($results) || $is_passed_time) {
                        $quizResult->update([
                            'results' => '',
                            'user_grade' => $totalMark,
                            'status' => CourseQuizzesResults::$failed,
                            'created_at' => now()
                        ]);

                        // update the progress
                        $course = $quiz->course;
                        $course->updateProgress();
                    }
                    else {
                        foreach ($results as $questionId => $result) {

                            if (!is_array($result)) {
                                unset($results[$questionId]);

                            } else {
                                $question = CourseQuizzesQuestion::where('id', $questionId)
                                    ->where('course_quizzes_id', $quiz->id)
                                    ->first();

                                if ($question->type == 'multiple') {
                                    if ($question and !empty($result['answer'])) {
                                        $answer = CourseQuizzesQuestionsAnswer::where('id', $result['answer'])
                                            ->where('question_id', $question->id)
                                            ->where('user_id', $quiz->user_id)
                                            ->first();

                                        $results[$questionId]['status'] = false;
                                        $results[$questionId]['grade'] = 0;

                                        if ($answer and $answer->correct) {
                                            $results[$questionId]['status'] = true;
                                            $results[$questionId]['grade'] = $question->grade;
                                            $totalMark += (int)$question->grade;
                                        }
                                    }
                                }
                                if ($question->type == 'descriptive') {
                                    if ($question and !empty($result['answer'])) {
                                        $answers = CourseQuizzesQuestionsAnswer::where('question_id', $question->id)
                                            ->where('user_id', $quiz->user_id)
                                            ->get();

                                        $results[$questionId]['status'] = false;
                                        $results[$questionId]['grade'] = 0;

                                        foreach ($answers as $answer) {
                                            if($answer->title == $result['answer']){
                                                $results[$questionId]['status'] = true;
                                                $results[$questionId]['grade'] = $question->grade;
                                                $totalMark += (int)$question->grade;
                                                // if ($answer->correct) {
                                                //     $results[$questionId]['status'] = true;
                                                //     $totalMark += (int)$question->grade;
                                                // }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (empty($status)) {
                            $status = ($totalMark >= $passMark) ? CourseQuizzesResults::$passed : CourseQuizzesResults::$failed;
                        }
                        // $results["attempt_number"] = $request->get('attempt_number');

                        $result_token = Hash::make(quickRandom(16)) . $quizResult->id;
                        $result_token = str_replace('%', '', $result_token);
                        $result_token = str_replace('/', '', $result_token);

                        $quizResult->update([
                            'results' => json_encode($results),
                            'user_grade' => $totalMark,
                            'status' => $status,
                            'result_token' => $result_token,
                            'created_at' => now()
                        ]);

                        // update the progress
                        $course = $quiz->course;
                        $course->updateProgress();


                        // Send notification if need reviewing
                        $title = 'حل امتحان ' . $quiz->title;
                        $text = "قام " . $user->name . " بالاجابة على اسئلة امتحان: " . $quiz->title;
                        $notification['title'] = $title;
                        $notification['text'] = $text;
                        $notification['user_type'] = 'user';
                        $notification['action_type'] = 'solve_quiz';
                        $notification['action_id'] = $quiz->id;
                        $notification['created_at'] = \Carbon\Carbon::now();

                        $teacher_id = $course->user_id;
                        $notification['user_id'] = $teacher_id;

                        Notifications::insert($notification);
                        sendWebNotification($teacher_id, 'user', $title, $text);


                        // Do something if passed

                        // if ($quizResult->status == CourseQuizzesResults::$passed) {
                        //     $passTheQuizReward = RewardAccounting::calculateScore(Reward::PASS_THE_QUIZ);
                        //     RewardAccounting::makeRewardAccounting($quizResult->user_id, $passTheQuizReward, Reward::PASS_THE_QUIZ, $quiz->id, true);

                        //     if ($quiz->certificate) {
                        //         $certificateReward = RewardAccounting::calculateScore(Reward::CERTIFICATE);
                        //         RewardAccounting::makeRewardAccounting($quizResult->user_id, $certificateReward, Reward::CERTIFICATE, $quiz->id, true);
                        //     }
                        // }

                    }

                    $data['quiz_id']      = $quiz->id;
                    $data['course_id']    = $quiz->course_id;

                    return $data;
                }
            }
        }
        abort(404);
    }

}
