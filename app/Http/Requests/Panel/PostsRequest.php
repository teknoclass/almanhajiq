<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest  extends FormRequest
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

        $rules['image'] = 'required';
        $rules['category_id'] = 'required';
        $rules['date_publication'] = 'required';

        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'required';
            $rules['text_' . $key] = 'required';

        }
        return $rules;
    }
}
