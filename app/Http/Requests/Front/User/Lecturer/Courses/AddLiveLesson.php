<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddLiveLesson extends FormRequest
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
            // 'course_sections_id' => 'required|numeric|exists:course_sections,id',
            // 'files.*'            => 'sometimes|mimes:jpeg,jpg,png,pdf|max:2048',
        ];

        foreach ($this->file('files') ??[] as $i => $file) {
            if($file->getClientOriginalExtension() == 'docx'){
                $rules['files.' . $i ] = 'sometimes|max:2048';
            }else{
                $rules['files.' . $i ] = 'sometimes|mimes:jpeg,jpg,png,pdf|max:2048';
            }
        }

        $rules['meeting_date'] = [ 'required', 'date:Y-m-d H:i:s', 'after_or_equal:today'];
        $rules['time_form'] = 'required';
        $rules['time_to'] = 'required|after:time_form';

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
            'status.required'             => 'حقل الحاله مطلوب.',
            'status.in'                   => 'قيمة الحاله يجب أن تكون "active" أو "inactive".',
            'meeting_date.required' => 'حقل تاريخ الجلسة مطلوب.',
            'meeting_date.date' => 'تاريخ الجلسة يجب أن يكون بتنسيق Y-m-d H:i:s.',
            'meeting_date.after_or_equal' => 'يجب أن يكون تاريخ بدء الجلسة بعد التاريخ الحالي.',
            'time_form.required' => 'حقل ساعة بدء الجلسة مطلوب.',
            'time_to.required' => 'حقل ساعة انتهاء الجلسة مطلوب.',
            'time_to.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البدء.',

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
