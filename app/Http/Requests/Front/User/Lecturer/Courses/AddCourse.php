<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class AddCourse extends FormRequest
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
        $max_size_file = 1024 * 10;

        $rules = [
            'type'              => 'required',
            'status'            => 'required|in:being_processed,ready,accepted,unaccepted',
            'language_id'       => 'required',
            'category_id'       => 'required',
            'level_id'          => 'required',
            'age_range_id'      => 'required',
            'start_date'        => 'nullable|date',
            'end_date'          => 'nullable|date',
            'number_of_free_lessons' => 'nullable|integer',
            'lessons_follow_up' => 'required',
            'image'             => 'required',
            'cover_image'       => 'required',
            'grade_level_id'    => 'required',
            'grade_sub_level'   => 'required',
            'video_image'       => 'nullable',
            'video'             => 'nullable|mimes:mp4|max:' . $max_size_file,
        ];

        foreach (locales() as $key => $language) {
            $rules["title_$key"] = 'required';
            $rules["description_$key"] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'type.required'                  => 'النوع مطلوب.',
            'status.required'                => 'الحالة مطلوبة.',
            'status.in'                      => 'الحالة يجب أن تكون إما "قيد المعالجة"، "جاهز"، "مقبول"، أو "غير مقبول".',
            'language_id.required'           => 'معرّف اللغة مطلوب.',
            'category_id.required'           => 'معرّف الفئة مطلوب.',
            'level_id.required'              => 'معرّف المستوى مطلوب.',
            'age_range_id.required'          => 'معرّف نطاق العمر مطلوب.',
            'start_date.date'                => 'تاريخ البداية يجب أن يكون تاريخًا صحيحًا.',
            'end_date.date'                  => 'تاريخ الانتهاء يجب أن يكون تاريخًا صحيحًا.',
            'number_of_free_lessons.integer' => 'عدد الدروس المجانية يجب أن يكون عددًا صحيحًا.',
            'lessons_follow_up.required'     => 'المتابعة بعد الدروس مطلوبة.',
            'image.required'                 => 'الصورة مطلوبة.',
            'cover_image.required'           => 'صورة الغلاف مطلوبة.',
            'video_image'                    => 'صورة الفيديو يجب أن تكون صورة صحيحة.',
            'video.url'                      => 'رابط الفيديو يجب أن يكون رابطًا صحيحًا.',
        ];

        foreach (locales() as $key => $language) {
            $messages["title{$key}.required"] = "حقل العنوان المختصرة باللغة {$language} مطلوب.";
            $messages["title{$key}.string"] = "حقل النبذة المختصرة باللغة {$language} يجب أن يكون نصًا.";
            $messages["description_{$key}.required"] = "حقل الوصف باللغة {$language} مطلوب.";
            $messages["description_{$key}.string"] = "حقل الوصف باللغة {$language} يجب أن يكون نصًا.";
        }

        return $messages;
    }
}
