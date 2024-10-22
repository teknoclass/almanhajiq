<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddSectionRequest extends FormRequest
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

        $rules['course_id']  = 'required|exists:courses,id';
        $rules['is_active']  = 'sometimes';
        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'course_id.required' => 'حقل الكورس مطلوب.',
        ];

        foreach (locales() as $key => $language) {
            $messages['title' . $key . '.required'] = 'حقل العنوان باللغة ' . $language . ' مطلوب.';
        }

        return $messages;
    }
}
