<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class LecturerPrivateLessonsSettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {

        return [
            'hour_price'        => 'required|numeric|min:0',
            'min_student_no'    => 'required|numeric|min:0',
            'max_student_no'    => 'required|numeric|min:0',

        ];
    }

    public function messages()
    {
        return [
            'hour_price.required'       => 'حقل سعر الساعة مطلوب',
            'hour_price.numeric'        => 'يجب أن يكون سعر الساعة قيمة رقمية',
            'hour_price.min'            => 'يجب أن يكون سعر الساعة على الأقل 0',

            'min_student_no.required'   => 'حقل الحد الأدنى لعدد الطلاب مطلوب',
            'min_student_no.numeric'    => 'يجب أن يكون الحد الأدنى لعدد الطلاب قيمة رقمية',
            'min_student_no.min'        => 'يجب أن يكون الحد الأدنى لعدد الطلاب على الأقل 0',

            'max_student_no.required'   => 'حقل الحد الأقصى لعدد الطلاب مطلوب',
            'max_student_no.numeric'    => 'يجب أن يكون الحد الأقصى لعدد الطلاب قيمة رقمية',
            'max_student_no.min'        => 'يجب أن يكون الحد الأقصى لعدد الطلاب على الأقل 0',
        ];
    }
}
