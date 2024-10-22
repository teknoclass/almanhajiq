<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class joinAsMarketRequestRequest extends FormRequest
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
        $max_size_file = 1024 * 3;

        $rules['name'] = 'required|string|max:255';
        $rules['mobile'] = 'required|string|max:255';
        $rules['email'] = 'required|string|max:255';//'|unique:users';
        $rules['bio'] = 'required|string|max:2000';
        $rules['gender'] = 'required|in:male,female';
        $rules['country_id'] = 'required';
        $rules['city'] = 'required|string|max:255';

        
        return $rules;
    }
}