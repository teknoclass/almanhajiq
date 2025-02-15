<?php

namespace App\Http\Requests\Front;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SignUpRequest  extends FormRequest
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
        $pass_role                 = $this->role == User::LECTURER ? 'nullable' : 'required';
        $rules['name']             = 'required|string';
        $rules['email']            = [
                                        'required',
                                        'email',
                                        Rule::unique('users')->whereNull('deleted_at')
                                    ];
        $rules['mobile']           = [
                                        'required',
                                        'numeric',
                                        Rule::unique('users')->whereNull('deleted_at')
                                    ];
        $rules['password']         = "$pass_role|string|min:6";
        $rules['country_id']       = 'nullable|numeric';
        $rules['agree_conditions'] = 'required';

        if($this->role == User::LECTURER){
            $rules['certificate_id'] = 'required';
            $rules['specialization_id'] = 'required';
        }

        return $rules;
    }
    public function messages()
    {
        $rules['name.required']     = __('Name_is_required');
        $rules['email.required']    = __('Email_is_required');
        $rules['email.unique']      = __('Email_is_used_before');
        $rules['mobile.required']   = __('Mobile_is_required');
        $rules['mobile.regex']      = __('Wrong_Mobile_Format');
        $rules['mobile.digits']     = __('Mobile_should_be_10_digite');
        $rules['password.required'] = __('Password_is_required');
        $rules['certificate_id.required'] = __('certificate_is_required');
        $rules['password.min']      = __('Password_should_be_greater_than_or_equal_6_characters');
        $rules['agree_conditions']  = __('Must_agree_to_conditions');
        $rules['specialization_id']  = __('specialization_required');

        return $rules;
    }
}
