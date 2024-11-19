<?php

declare(strict_types=1);

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest
 *
 * Handles the validation for updating a user's profile.
 */
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $user = auth('web')->user();
        $maxFileSize = 1024 * 3; // 3 MB max file size
        $codeCountry = (string) $this->get('code_country');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                Rule::unique('users')->where('code_country', $codeCountry)->ignore($user->id),
            ],
            'image' => [
                'nullable',
                'dimensions:min_width=100,max_width=1500',
                'mimes:jpeg,png,pdf,jpg',
                'max:' . $maxFileSize,
            ],
            'gender' => 'required|in:male,female',
            'country_id' => 'required|numeric',
            'city' => 'string|max:255',
            'mother_lang_id' => 'nullable|numeric',
            // 'dob' => 'nullable|date|before:-3 years',
        ];

        if ($this->checkUser('student')) {
            $rules['trainer_name'] = 'required|string|max:255';
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.name'),
            'email.required' => __('validation.email'),
            'mobile.required' => __('validation.mobile'),
            'gender.required' => __('validation.gender'),
            'country_id.required' => __('validation.country_id'),
            'city.required' => __('validation.city'),
            'mother_lang_id.numeric' => __('validation.mother_lang_id'),
            'dob.before' => __('validation.dob'),
        ];
    }

    /**
     * Check if the authenticated user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    private function checkUser(string $role): bool
    {
        return $this->user()->hasRole($role);
    }
}
