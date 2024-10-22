<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class OurTeamsRequest extends FormRequest
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

        $rules['image' ] = 'required';

        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required';
            $rules['job_' . $key] = 'required';
            $rules['description_' . $key] = 'required';
        }


        return $rules;
    }
}
