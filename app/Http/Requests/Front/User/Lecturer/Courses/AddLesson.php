<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddLesson extends FormRequest
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
            // 'accessibility'      => 'required|in:free,paid',
            // 'files.*'            => 'sometimes|mimes:jpeg,jpg,png,pdf|max:2048',
            'video_duration' => 'sometimes|nullable|integer|min:1',
            'listen_duration' => 'sometimes|nullable|integer|min:1',
        ];

        foreach ($this->file('files') ?? [] as $i => $file) {
            if($file->getClientOriginalExtension() == 'docx'){
                $rules['files.' . $i ] = 'sometimes|max:2048';
            }else{
                $rules['files.' . $i ] = 'sometimes|mimes:jpeg,jpg,png,pdf|max:2048';
            }
        }

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
            'accessibility.required'      => 'حقل امكانية الوصول مطلوب.',
            'accessibility.in'            => 'قيمة مكانية الوصول يجب أن تكون "free" أو "paid".',
            'downloadable.required'       => 'حقل هل قابل للتنزيل مطلوب.',
            'downloadable.numeric'        => 'حقل هل قابل للتنزيل يجب أن يكون رقميًا.',
            'status.required'             => 'حقل الحاله مطلوب.',
            'status.in'                   => 'قيمة الحاله يجب أن تكون "active" أو "inactive".',
            'video_duration.numeric'           => 'حقل  المدة يجب أن يكون رقميًا.',
            'listen_duration.numeric'           => 'حقل المدة يجب أن يكون رقميًا.',
            'files.*.mimes'           => 'يرجي مراعات نوع الملفات الموضحة اسفل الحقل.',

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
