<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class LecturerEducationSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $max_size_file = 1024 * 10;

        if ($this->tab == 'contact') {
            $rules = [
                'twitter' => 'nullable|url',
                'facebook' => 'nullable|url',
                'instagram' => 'nullable|url',
                'linkedin' => 'nullable|url',
                'youtube' => 'nullable|url',
            ];

            return $rules;
        }

        if ($this->tab == 'financial') {
            $rules = [
                'bank_id'         => 'required|integer',
                'account_num' => 'required|numeric',
                'name_in_bank'    => 'required|string',
                'iban'            => 'required|string',
            ];

            return $rules;
        }

        if ($this->tab == 'timetable') {
            $rules = [
                'days.*'         => 'required|array',
                'days.*.*.from' => 'nullable|date_format:H:i',
                'days.*.*.to'    => 'nullable|date_format:H:i|after:from',
            ];

            return $rules;
        }

        $rules = [
            'major_id' => 'required|integer',
            'video_file' => 'nullable|mimes:mp4|max:'.$max_size_file,
            'exp_years' => 'nullable|integer|min:0',
            'video_thumbnail' => 'required',
        ];

        foreach (locales() as $key => $language) {
            $rules['abstract_' . $key] = 'nullable|string|max:600';
            $rules['description_' . $key] = 'required|string';
            $rules['position_' . $key] = 'nullable|string';
        }

        return $rules;

    }

    public function messages()
    {
        $messages = [
            'major_id.required' => 'حقل  التخصص مطلوب.',
            'major_id.integer' => 'حقل  التخصص يجب أن يكون عددًا صحيحًا.',
            'video.mimes' => 'يجب أن يكون الفيديو من نوع MP4 صالح.',
            'video.max' => 'حجم ملف الفيديو لا يمكن أن يتجاوز :max كيلوبايت.',
            'exp_years.integer' => 'حقل سنوات الخبرة يجب أن يكون عددًا صحيحًا.',
            'exp_years.min' => 'حقل سنوات الخبرة يجب أن لا يقل عن 0.',
            'twitter.url' => 'حقل Twitter يجب أن يكون عنوان URL صحيحًا.',
            'facebook.url' => 'حقل Facebook يجب أن يكون عنوان URL صحيحًا.',
            'instagram.url' => 'حقل Instagram يجب أن يكون عنوان URL صحيحًا.',
            'linkedin.url' => 'حقل LinkedIn يجب أن يكون عنوان URL صحيحًا.',
            'youtube.url' => 'حقل YouTube يجب أن يكون عنوان URL صحيحًا.',
            'bank_id.required'              => 'حقل رقم البنك مطلوب.',
            'bank_id.integer'               => 'رقم البنك يجب أن يكون عددًا صحيحًا.',
            'bank_account_num.required'     => 'حقل رقم الحساب البنكي مطلوب.',
            'bank_account_num.numeric'      => 'رقم الحساب البنكي يجب أن يكون رقمًا.',
            'name_in_bank.required'         => 'حقل الاسم في البنك مطلوب.',
            'name_in_bank.string'           => 'اسم في البنك يجب أن يكون نصًا.',
            'iban.required'                 => 'حقل الآيبان مطلوب.',
            'iban.string'                   => 'الآيبان يجب أن يكون نصًا.',
            'video_thumbnail.required'      => 'حقل الصورة المصغرة للفيديو مطلوبة.',
            'days.*.*.from.date_format'    => 'تاريخ البداية يجب ان يكون  ساعة:دقيقة',
            'days.*.*.to.date_format'    => 'تاريخ النهاية يجب ان يكون ساعة:دقيقة',
            'days.*.*.to.after'    => 'تاريخ النهاية يجب ان اكبر من تاريخ البداية',
        ];

        foreach (locales() as $key => $language) {
            $messages['abstract_' . $key . '.string'] = 'حقل النبذة المختصرة باللغة ' . $language . ' يجب أن يكون نصًا.';
            $messages['abstract_' . $key . '.max'] = 'حقل النبذة المختصرة باللغة ' . $language . ' يجب أن لا يتجاوز 600 حرف.';
            $messages['description_' . $key . '.required'] = 'حقل الوصف باللغة ' . $language . ' مطلوب.';
            $messages['description_' . $key . '.string'] = 'حقل الوصف باللغة ' . $language . ' يجب أن يكون نصًا.';
            $messages['position_' . $key . '.string'] = 'حقل المسمى الوظيفي باللغة ' . $language . ' يجب أن يكون نصًا.';
        }

        return $messages;
    }

}
