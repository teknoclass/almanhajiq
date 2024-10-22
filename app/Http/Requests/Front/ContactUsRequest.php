<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactUsRequest  extends FormRequest
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


        $rules['name'] = 'required|string|max:255';
        $rules['email']  = 'required|email';
        $rules['subject']  = 'required|string|max:255';
        $rules['text']  = 'required|string';


        return $rules;
    }
}
