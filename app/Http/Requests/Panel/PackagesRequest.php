<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class PackagesRequest  extends FormRequest
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

        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'required';
            $rules['description_' . $key] = 'required';
        }
        $rules['price'] = 'required|numeric|min:1|';
        $rules['num_hours'] = 'required|numeric|min:1|';


        return $rules;
    }

    public function messages()
    {


        $messages = [
            'price.required' => 'حقل السعر مطلوب.',
            'price.numeric' => 'السعر يجب أن يكون رقمياً.',
            'price.min' => 'السعر يجب أن يكون على الأقل 1.',
            'num_hours.required' => 'حقل عدد الساعات مطلوب.',
            'num_hours.numeric' => 'عدد الساعات يجب أن يكون رقمياً.',
            'num_hours.min' => 'عدد الساعات يجب أن يكون على الأقل 1.',
        ];

        foreach (locales() as $key => $language) {
            $messages['title_' . $key . '.required'] = 'حقل العنوان باللغة ' . $language . ' مطلوب.';
            $messages['description_' . $key . '.required'] = 'حقل الوصف باللغة ' . $language . ' مطلوب.';
        }

        return $messages;
    }
}
