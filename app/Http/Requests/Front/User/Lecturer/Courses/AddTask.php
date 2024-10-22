<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddTask extends FormRequest
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
            'course_id'          => 'required|numeric|exists:courses,id',
          //  'course_sections_id' => 'required|numeric|exists:course_sections,id',
            'time'               => 'required|numeric',
        ];

        foreach (locales() as $key => $language) {
            $rules['title' . $key] = 'nullable|string';
            $rules['description_' . $key] = 'required|string';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'course_id.required'          => 'حقل الكورس مطلوب.',
            'course_id.numeric'           => 'حقل الكورس يجب أن يكون رقميًا.',
            'course_id.exists'            => 'قيمة الكورس غير موجودة في الجدول.',
            'course_sections_id.required' => 'حقل القسم مطلوب.',
            'course_sections_id.numeric'  => 'حقل القسم يجب أن يكون رقميًا.',
            'course_sections_id.exists'   => 'قيمة القسم غير موجودة في الجدول.',
            'time.required'               => 'حقل المده مطلوب.',
            'time.numeric'                => 'حقل المده يجب ان يكون رقم',
        ];

        foreach (locales() as $key => $language) {
            $messages['title' . $key . '.required'] = 'حقل العنوان المختصرة باللغة ' . $language . ' مطلوب.';
            $messages['title' . $key . '.string'] = 'حقل النبذة المختصرة باللغة ' . $language . ' يجب أن يكون نصًا.';
            $messages['description_' . $key . '.required'] = 'حقل الوصف باللغة ' . $language . ' مطلوب.';
            $messages['description_' . $key . '.string'] = 'حقل الوصف باللغة ' . $language . ' يجب أن يكون نصًا.';
        }

        return $messages;
    }
}
