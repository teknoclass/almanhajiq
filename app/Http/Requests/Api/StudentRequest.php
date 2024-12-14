<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $rules['name']             = 'required|string';
        $rules['email']            = 'required|email|unique:users';
        $rules['mobile']           = 'required|numeric|unique:users';
        $rules['password']         = "required|min:6|confirmed";
        $rules['country_id']       = 'nullable|numeric';
        $rules['agree_conditions'] = 'required';
        $rules['code_country']     = 'required';



        return $rules;
    }

}
