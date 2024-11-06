<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
        $userId =   $this->user();

        return [
            'name'             => 'nullable|string',
            'email'            => [
                'nullable',
                'email',
                Rule::unique('users')->whereNotNull('email')->whereNull('deleted_at')->ignore($userId),
            ],
            'mobile'           => [
                'nullable',
                'numeric',
                'digits_between:10,15',
                Rule::unique('users')->whereNotNull('mobile')->whereNull('deleted_at')->ignore($userId),
            ],
            'country_id'       => 'nullable|numeric',
            'agree_conditions' => 'nullable',
            'code_country'     => 'nullable'
        ];

    }

}
