<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagesRequest  extends FormRequest
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
        if(request()->route('id')){
            $rules['sulg']  = 'required|regex:/^\S*$/u|'.Rule::unique('pages')->whereNotNull('sulg')->whereNot('id',request()->route('id'))->whereNull('deleted_at');

        }else{
            $rules['sulg'] = 'required|regex:/^\S*$/u|'.Rule::unique('pages')->whereNotNull('sulg')->whereNull('deleted_at');
        }


        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'required';
        }

        return $rules;
    }
}
