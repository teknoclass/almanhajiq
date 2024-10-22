<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddQuiz extends FormRequest
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
        $rules =  [
            'course_id'         => 'required|numeric|exists:courses,id',
            'time'              => 'required|numeric',
            'grade'             => 'required|numeric',
            'pass_mark'         => 'required|numeric|lt:grade',
        ];

        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'nullable|string';
            $rules['description_' . $key] = 'required|string';

            foreach ($this->input('questions_' . $key, []) as $questionNo => $question) {
                $questionNo++;
                $type = $this->input("question_{$questionNo}_type");

                if ($type === 'descriptive') {
                    // For descriptive questions
                    $rules["complete_question_answers_{$key}_{$questionNo}"] = 'required|array|min:1';
                    $rules["complete_question_answers_{$key}_{$questionNo}.*"] = 'required|string';
                    $rules["complete_question_{$questionNo}_mark"] = 'required|numeric';
                } elseif ($type === 'multiple') {
                    // For multiple-choice questions
                    $rules["question_answers_{$key}_{$questionNo}"] = 'required|array|min:1';
                    $rules["question_answers_{$key}_{$questionNo}.*"] = 'required|string';
                    $rules["correct_answer_{$questionNo}"] = 'required|array|min:1|max:' . count($this->input("question_answers_{$key}_{$questionNo}"));
                    $rules["question_{$questionNo}_mark"] = 'required|numeric';
                }
            }
        }
        return $rules;
    }

    public function messages()
{
    $messages = [
        'course_id.required'            => 'حقل الكورس مطلوب.',
        'course_id.numeric'             => 'حقل الكورس يجب أن يكون رقميًا.',
        'course_id.exists'              => 'قيمة الكورس غير موجودة في الجدول.',
        'time.required'                 => 'حقل المده مطلوب.',
        'time.numeric'                  => 'حقل المده يجب أن يكون رقمًا.',
        'grade.required'                => 'حقل الدرجة مطلوب.',
        'grade.numeric'                 => 'حقل الدرجة يجب أن يكون رقميًا.',
        'pass_mark.required'            => 'حقل درجة النجاح مطلوب.',
        'pass_mark.numeric'             => 'حقل درجة النجاح يجب أن يكون رقميًا.',
        'pass_mark.lt'                  => 'حقل درجة النجاح يجب أن يكون أقل من حقل الدرجة.',

    ];

    foreach (locales() as $key => $language) {
        $messages["title_{$key}.required"]          = 'حقل العنوان المختصرة باللغة ' . $language . ' مطلوب.';
        $messages["title_{$key}.string"]            = 'حقل النبذة المختصرة باللغة ' . $language . ' يجب أن يكون نصًا.';
        $messages["description_{$key}.required"]    = 'حقل الوصف باللغة ' . $language . ' مطلوب.';
        $messages["description_{$key}.string"]      = 'حقل الوصف باللغة ' . $language . ' يجب أن يكون نصًا.';

        foreach ($this->input("questions_{$key}", []) as $questionNo => $question) {
            $questionNo++;
            $type = $this->input("question_{$questionNo}_type");

            if ($type === 'descriptive') {
                $messages["complete_question_answers_{$key}_{$questionNo}.required"] = "حقل الإجابة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
                $messages["complete_question_answers_{$key}_{$questionNo}.*.required"]   = "حقل الإجابة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
                $messages["complete_question_{$questionNo}_mark.required"] = "حقل الدرجة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
            } elseif ($type === 'multiple') {
                $messages["question_answers_{$key}_{$questionNo}.required"]     = "حقل الإجابات للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
                $messages["question_answers_{$key}_{$questionNo}.*.required"]   = "حقل الإجابة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
                $messages["correct_answer_{$questionNo}.required"]              = "حقل الإجابة الصحيحة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
                $messages["question_{$questionNo}_mark.required"]               = "حقل الدرجة للسؤال رقم {$questionNo} باللغة {$language} مطلوب.";
            }
        }
    }

    return $messages;
}

}
