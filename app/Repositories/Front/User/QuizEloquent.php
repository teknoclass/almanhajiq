<?php

namespace App\Repositories\Front\User;

use App\Http\Resources\Quiz\QuestionResource;
use App\Http\Resources\Quiz\ShowResultQuestionResource;
use App\Http\Resources\Quiz\StartQuizResource;
use App\Models\CourseQuizzes;
use App\Models\CourseQuizzesQuestion;
use App\Models\CourseQuizzesQuestionsAnswer;
use App\Models\CourseQuizzesResults;
use App\Models\Notifications;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\CourseQuizzesResultsAnswers;

class QuizEloquent extends HelperEloquent
{

    public function start($request, $course_id, $id, $is_web = true)
    {
        $quiz = CourseQuizzes::where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->with('course')
            ->first();

        $user = $this->getUser($is_web);

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

                if(!$is_web){
                    $quiz = CourseQuizzes::where('id', $id)
                    ->with([
                        'quizQuestions' => function ($query) use ($quizResult) {
                            $query->with('quizzesQuestionsAnswers')
                            ->with(['userAnswer' => function ($query) use ($quizResult){
                                $query->where('result_id',$quizResult->id);
                            }]);
                        },
                    ])
                    ->with('course')
                    ->first();
                }

                $data = [
                    'quiz' => $quiz,
                    'quizQuestions' => $quiz->quizQuestions,
                    'quizResult' => $quizResult
                ];

                if(!$is_web){
                    $data['quiz'] = new StartQuizResource($data['quiz']);
                    $data['quizQuestions'] = QuestionResource::collection($data['quizQuestions']);
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $quizResult->started_at)->addMinutes($quiz->time);
                    $current = Carbon::now();
                    $data['remaining_time'] = $current->diffInSeconds($end_time);
                    unset($data['quizResult']);
                }

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

                        if(!$is_web){
                            $quiz = CourseQuizzes::where('id', $id)
                            ->with([
                                'quizQuestions' => function ($query) use ($userQuizSolution) {
                                    $query->with('quizzesQuestionsAnswers')
                                    ->with(['userAnswer' => function ($query) use ($userQuizSolution){
                                        $query->where('result_id',$userQuizSolution->id);
                                    }]);
                                },
                            ])
                            ->with('course')
                            ->first();
                        }

                        $data = [
                            'quiz' => $quiz,
                            'quizQuestions' => $quiz->quizQuestions,
                            'quizResult' => $userQuizSolution
                        ];

                        if(!$is_web){
                            $data['quiz'] = new StartQuizResource($data['quiz']);
                            $data['quizQuestions'] = QuestionResource::collection($data['quizQuestions']);
                            unset($data['quizResult']);
                            $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $userQuizSolution->started_at)->addMinutes($quiz->time);
                            $current = Carbon::now();
                            $data['remaining_time'] = $current->diffInSeconds($end_time);
                        }

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

    function submitAnswer($request,$is_web = true){

        $user = $this->getUser($is_web);

        $result = CourseQuizzesResults::where('user_id',$user->id)->where('quiz_id',$request['quiz_id'])->first();

        $answer = CourseQuizzesResultsAnswers::updateOrCreate([
            'result_id' => $result->id,
            'question_id' => $request['question_id']],[
            'answer_id' => $request['answer_id'] ?? null,
            'text_answer' => $request['text_answer'] ?? null
        ]);



    }

    function submitResultApi($request,$is_web = true){
        if($is_web)$guardType = 'web';
        else $guardType = 'api';

        $user = $this->getUser($is_web);
        $quizId = $request->get('quiz_id');
        $quiz = CourseQuizzes::where('id',$quizId)->first();
        $data['quiz_id'] = $quizId;
        $data['course_id'] = $quiz->course_id;
        $results = CourseQuizzesResults::where('quiz_id',$quizId)->where('user_id',$user->id)
        ->with([
            'answers' => function ($query){
                $query->with(['answer' => function($query){
                    $query->with('question');
                },
                'question' => function($query){
                    $query->with('quizzesQuestionsAnswers');
                }]);
            },

        ])

        ->first();
        if(!$results){
            $results = CourseQuizzesResults::create([
                'quiz_id' => $quizId,
                'user_id' => $user->id,
                'course_id' => $quiz->course_id,
                'status' => 'waiting',
                'results' => '',
                'user_grade' => 0,
                'status' => CourseQuizzesResults::$failed,
                'created_at' => now()
            ]);
            // update the progress
            $course = $quiz->course;
            if($is_web)$course->updateProgress();
        }else{

            if($results->result_token != null){
                $data['message']  = 'quiz_done_before';
                $data['status'] = false;
                return $data;
            }
            $status = '';

            $now = Carbon::now();
            $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $results->started_at)->addMinutes($quiz->time);

            $is_passed_time = $now > $end_time;
            if($is_passed_time){

                $results->update([
                    'results' => '',
                    'user_grade' => 0,
                    'status' => CourseQuizzesResults::$failed,
                    'created_at' => now()
                ]);

                // update the progress
                $course = $quiz->course;
                if($is_web)$course->updateProgress();

                $data['message'] = 'quiz_time_passed';
                $data['status'] = false;

                return $data;



            }else{

                $totalMark = 0;
                foreach($results->answers as $answer  ){
                    if($answer->question->type == 'multiple'){
                        if($answer->answer->correct == 1){
                            $totalMark += $answer->answer->question->grade;
                            CourseQuizzesResultsAnswers::where('id',$answer->id)->update(['status' => 1,'mark' => $answer->answer->question->grade]);
                        }
                    }else{
                        if($answer->question->quizzesQuestionsAnswers != null){

                            foreach($answer->question->quizzesQuestionsAnswers as $ans){
                                if($answer->text_answer == $ans->title){
                                    $totalMark += $ans->question->grade;
                                    CourseQuizzesResultsAnswers::where('id',$answer->id)->update(['status' => 1,'mark' => $ans->question->grade]);
                                    break;
                                }
                            }
                        }
                    }
                }
                $status = ($totalMark >= $quiz->pass_mark) ? CourseQuizzesResults::$passed : CourseQuizzesResults::$failed;

                $result_token = Hash::make(quickRandom(16)) . $results->id;
                $result_token = str_replace('%', '', $result_token);
                $result_token = str_replace('/', '', $result_token);
                $results->update([
                    'results' => '',
                    'user_grade' => $totalMark,
                    'status' => $status,
                    'result_token' => $result_token,
                    'created_at' => now()
                ]);

                $course = $quiz->course;
                if($is_web)$course->updateProgress($guardType);

                $data['status'] = true;
                $data['message'] = __('message.operation_accomplished_successfully');

                return $data;


            }


        }


    }

    function showResultsApi($item_id){

        $quizResult = CourseQuizzesResults::where('quiz_id',$item_id)->where('user_id',auth('api')->id())->first();

        $quiz = CourseQuizzes::where('id', $item_id)
                    ->with([
                        'quizQuestions' => function ($query) use ($quizResult) {
                            $query->with('quizzesQuestionsAnswers')
                            ->with(['userAnswer' => function ($query) use ($quizResult){
                                $query->where('result_id',$quizResult->id);
                            }]);
                        },
                    ])
                    ->with('course')
                    ->first();

        $questionCount = 0;
        $correctCount = 0;
        foreach($quiz->quizQuestions as $quest){
            $questionCount+=1;
            foreach($quest->quizzesQuestionsAnswers as $ans){
                if($ans->correct == 1){
                    if($quest->type == 'multiple'){
                        if($ans->id == $quest->user_answer)$correctCount+=1;
                    }
                }
            }
        }
        $data['user_grade'] = $quizResult->user_grade;
        $data['grade'] = $quiz->grade;
        $data['status'] = $quizResult->status;
        $quiz = ShowResultQuestionResource::collection($quiz->quizQuestions);
        $data['question'] = $quiz;
        $data['questionCount'] = $questionCount;
        $data['correctCount'] = $correctCount;
        return $data;
    }

}
