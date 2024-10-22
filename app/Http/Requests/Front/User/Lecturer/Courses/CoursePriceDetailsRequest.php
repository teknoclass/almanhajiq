<?php

namespace App\Http\Requests\Front\User\Lecturer\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CoursePriceDetailsRequest extends FormRequest
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
        $rules['price'] = "sometimes|min:0|numeric";
        $rules['discount_price'] = "sometimes|min:0|numeric";
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'price.numeric'                  => 'يرجى إدخال قيمة صحيحة للسعر.',
            'discount_price.numeric'                => 'يرجى إدخال قيمة صحيحة للسعر بعد الخصم.',
        ];
        return $messages;
    }
}
