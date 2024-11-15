<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Quiz\SubmitQuizQuestionAnswerRequest;
use App\Http\Requests\API\Quizzes\SubmitQuizQuestionAnswer;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use App\Repositories\Front\User\QuizEloquent;
use GrahamCampbell\ResultType\Success;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    private $quiz;

    public function __construct(QuizEloquent $quiz_eloquent)
    {
        $this->quiz = $quiz_eloquent;
    }

    public function start(Request $request, $id)
    {
        $data = $this->quiz->start($request, null, $id,false);
        $status = true;
        $message = __('message.operation_accomplished_successfully');
        if (@$data['error'] == 'quiz_done'){

            $message = __('message.quiz_done_before');
            $status = false;
        }


        if (@$data['error'] == 'quiz_time_passed'){

            $message = __('message.quiz_time_passed');
            $status = false;
        }

        if($status){
            $response = new SuccessResponse($message,$data,Response::HTTP_OK);
            return response()->success($response);
        }else{
            $response = new ErrorResponse($message,Response::HTTP_BAD_REQUEST);
            return response()->error($response);
        }

    }

    public function storeResult(Request $request)
    {
        $data = $this->quiz->submitResultApi($request,false);

        $response = new SuccessResponse($data['message'],null,Response::HTTP_OK);
        return response()->success($response);

    }

    function showResults($id){
        $data = $this->quiz->showResultsApi($id);
        $message = __('message.operation_accomplished_successfully');

        $response = new SuccessResponse($message,$data,Response::HTTP_OK);
        return response()->success($response);
    }

    function submitAnswer(SubmitQuizQuestionAnswerRequest $request){

        $data = $this->quiz->submitAnswer($request,false);
        $message = __('message.operation_accomplished_successfully');

        $response = new SuccessResponse($message,$data,Response::HTTP_OK);
        return response()->success($response);
    }
}
