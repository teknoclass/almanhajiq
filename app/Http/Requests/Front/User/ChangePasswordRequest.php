<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest  extends FormRequest
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

        $rules['current_password']  = 'required|string|min:6';
        $rules['new_password']  = 'required|string|min:6';
        $rules['new_password_confirmation']  = 'required|string|min:6|same:new_password';

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'current_password.required' => 'حقل كلمة المرور الحالية مطلوب.',
            'current_password.string' => 'يجب أن تكون كلمة المرور الحالية نصًا.',
            'current_password.min' => 'يجب أن تتكون كلمة المرور الحالية من على الأقل 6 أحرف.',
            'new_password.required' => 'حقل كلمة المرور الجديدة مطلوب.',
            'new_password.string' => 'يجب أن تكون كلمة المرور الجديدة نصًا.',
            'new_password.min' => 'يجب أن تتكون كلمة المرور الجديدة من على الأقل 6 أحرف.',
            'new_password_confirmation.required' => 'حقل تأكيد كلمة المرور الجديدة مطلوب.',
            'new_password_confirmation.string' => 'يجب أن يكون تأكيد كلمة المرور الجديدة نصًا.',
            'new_password_confirmation.min' => 'يجب أن يتكون تأكيد كلمة المرور الجديدة من على الأقل 6 أحرف.',
            'new_password_confirmation.same' => 'تأكيد كلمة المرور الجديدة يجب أن يتطابق مع كلمة المرور الجديدة.',
        ];

        return $messages;

    }
}
