<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class PrivateLessonsRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules['student_id'] = 'nullable';
        $rules['teacher_id'] = 'required';
        $rules['meeting_type'] = 'required';
        $rules['category_id'] = 'required';
        logger(request());
        if(!empty(request()->id)) {
            //$rules['meeting_date'] = [ 'required', 'date:Y-m-d', 'after_or_equal:today'];
            //$rules['time_form'] = 'required';
            //$rules['time_to'] = 'required|after:time_form';
            $rules['meeting_date'] = ['required', 'array'];
            $rules['meeting_date.*'] = ['date:Y-m-d', 'after_or_equal:today'];
            $rules['time_form'] = 'required|array';
            $rules['time_to'] = 'required|array';
        } else {
            $rules['meeting_date'] = ['required', 'array'];
            $rules['meeting_date.*'] = ['date:Y-m-d', 'after_or_equal:today'];
            $rules['time_form'] = 'required|array';
            $rules['time_to'] = 'required|array';
        }
        // $rules['price'] = 'required|numeric|min:0|';
        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'nullable';
            // $rules['description_' . $key] = 'required';
        }


        return $rules;
    }

    public function messages()
    {


        $messages = [
            'teacher_id.required' => 'حقل مدرب الجلسة مطلوب.',
            'meeting_type.required' => 'حقل نوع الجلسة مطلوب.',
            'category_id.required' => 'حقل فئة الجلسة مطلوب.',
            'meeting_date.required' => 'حقل تاريخ الجلسة مطلوب.',
            'meeting_date.date' => 'تاريخ الجلسة يجب أن يكون بتنسيق Y-m-d H:i:s.',
            'meeting_date.after_or_equal' => 'يجب أن يكون تاريخ بدء الجلسة بعد التاريخ الحالي.',
            'time_form.required' => 'حقل ساعة بدء الاجتماع مطلوب.',
            'time_to.required' => 'حقل ساعة انتهاء الاجتماع مطلوب.',
            'time_to.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البدء.',
            // 'price.required' => 'حقل السعر مطلوب.',
            // 'price.numeric' => 'السعر يجب أن يكون رقمياً.',
            // 'price.min' => 'السعر يجب أن يكون على الأقل 0.',
        ];

        foreach (locales() as $key => $language) {
            $messages['title_' . $key . '.required'] = 'حقل العنوان باللغة ' . $language . ' مطلوب.';
            $messages['description_' . $key . '.required'] = 'حقل الوصف باللغة ' . $language . ' مطلوب.';
        }

        return $messages;
    }
}
