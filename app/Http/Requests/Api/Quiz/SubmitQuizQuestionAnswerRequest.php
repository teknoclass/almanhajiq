<?php

namespace App\Http\Requests\Api\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizQuestionAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quiz_id' => 'required|exists:course_quizzes,id',
            'question_id' => 'required|exists:course_quizzes_questions,id',
            'answer_id' => 'exists:course_quizzes_questions_answers,id',
            'text_answer' => 'string'
        ];
    }
}
