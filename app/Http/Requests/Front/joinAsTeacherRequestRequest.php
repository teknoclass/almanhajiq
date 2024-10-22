<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
class joinAsTeacherRequestRequest extends FormRequest
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
        $max_size_file = 1024 * 3;

        $rules['name']                     = 'required|string|max:255';
        $rules['email']                    = 'required|email|'. Rule::unique('join_as_teacher_requests')->whereNotNull('email')->whereNull('deleted_at');
        $rules['mobile']                   = 'required|' . Rule::unique('join_as_teacher_requests')->whereNotNull('mobile')->whereNull('deleted_at');
        $rules['about']                    = 'required|string|max:255';
        $rules['gender']                   = ['required'];
        $rules['specialization_id']            = ['required' ,'exists:categories,id'];
        $rules['material_id']            = ['required' ,'exists:categories,id'];
        $rules['certificate_id']           = ['required' ,'exists:categories,id'];
        $rules['country_id']               = ['required' ,'exists:categories,id'];
        $rules['city']                     = 'required|string|max:255';
        $rules['id_image']                 = 'required|mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        $rules['job_proof_image']          = 'mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        $rules['cv_file']                  = 'required|mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;

        return $rules;
    }

    public function messages()
    {
        $max_size_file = 1024 * 3;
        return [

            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'حقل الاسم يجب أن يكون نصًا.',
            'name.max' => 'حقل الاسم يجب ألا يتجاوز 255 حرفًا.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'حقل البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صحيح.',
            'email.unique' => 'قيمة حقل البريد الإلكتروني مستخدمة بالفعل.',
            'mobile.required' => 'حقل الجوال مطلوب.',
            'mobile.unique' => 'قيمة حقل الجوال مستخدمة بالفعل.',
            'about.required' => 'حقل حول المدرب مطلوب.',
            'about.string' => 'حقل حول المدرب يجب أن يكون نصًا.',
            'about.max' => 'حقل حول المدرب يجب ألا يتجاوز 255 حرفًا.',
            'specialization_id.required' => 'حقل معرف التخصص مطلوب.',
            'specialization_id.exists' => 'قيمة حقل معرف التخصص غير صحيحة.',
            'material_id.required' => 'حقل معرف المادة مطلوب.',
            'material_id.exists' => 'قيمة حقل معرف المادة غير صحيحة.',
            'gender.required' => 'حقل الجنس مطلوب.',
            'gender.in' => 'قيمة حقل الجنس غير صحيحة.',
            'certificate_id.required' => 'حقل معرف الشهادة مطلوب.',
            'certificate_id.exists' => 'قيمة حقل معرف الشهادة غير صحيحة.',
            'country_id.required' => 'حقل معرف البلد مطلوب.',
            'country_id.exists' => 'قيمة حقل معرف البلد غير صحيحة.',
            'city.required' => 'حقل المدينة مطلوب.',
            'city.string' => 'حقل المدينة يجب أن يكون نصًا.',
            'city.max' => 'حقل المدينة يجب ألا يتجاوز 255 حرفًا.',
            'id_image.required' => 'حقل صورة الهوية مطلوب.',
            'id_image.mimes' => 'صيغة حقل صورة الهوية غير صالحة. يجب أن تكون الصورة من نوع jpeg، png، pdf، أو jpg.',
            'id_image.max' => 'حجم حقل صورة الهوية يجب ألا يتجاوز ' . $max_size_file . ' كيلوبايت.',
            'job_proof_image.mimes' => 'صيغة حقل صورة إثبات العمل غير صالحة. يجب أن تكون الصورة من نوع jpeg، png، pdf، أو jpg.',
            'job_proof_image.max' => 'حجم حقل صورة إثبات العمل يجب ألا يتجاوز ' . $max_size_file . ' كيلوبايت.',
            'cv_file.required' => 'حقل ملف السيرة الذاتية مطلوب.',
            'cv_file.mimes' => 'صيغة حقل ملف السيرة الذاتية غير صالحة. يجب أن يكون الملف من نوع jpeg، png، pdf، أو jpg.',
            'cv_file.max' => 'حجم حقل ملف'
        ];
    }

}
