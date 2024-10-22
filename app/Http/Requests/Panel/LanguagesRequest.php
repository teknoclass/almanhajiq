<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class LanguagesRequest extends FormRequest
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
        if (request()->route('id')) {

            $rules = [
                'is_rtl' => 'required',
                'is_default' => 'required',
                'lang' => 'required|unique:languages,lang,' . request()->route('id'),
            ];
        } else {

            $rules = [
                'is_rtl' => 'required',
                'is_default' => 'required',
                'lang' => 'required|unique:languages',
            ];
        }



        return $rules;
    }
}
