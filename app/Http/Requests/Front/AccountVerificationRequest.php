<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountVerificationRequest  extends FormRequest
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



        $rules['code_1']  = 'required';
        $rules['code_2']  = 'required';
        $rules['code_3']  = 'required';
        $rules['code_4']  = 'required';
        $rules['code_5']  = 'required';
        $rules['code_6']  = 'required';


        return $rules;
    }
}
