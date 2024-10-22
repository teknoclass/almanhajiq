<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersRequest extends FormRequest
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

        $code_country=request()->get('code_country');


        if (request()->route('id')) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|' . Rule::unique('users')->whereNotNull('email')->whereNot('id', request()->route('id'))->whereNull('deleted_at'),
                'mobile' => 'required|' .
                Rule::unique('users')->whereNotNull('mobile')
                ->where('code_country', $code_country)
                ->whereNot('id', request()->route('id'))->whereNull('deleted_at'),
                'can_add_half_hour' => 'nullable'
            ];
        } else {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|' . Rule::unique('users')->whereNotNull('email')->whereNull('deleted_at'),
                'password' => 'required|min:6',
                    'mobile' => 'required|' . Rule::unique('users')->whereNotNull('mobile')
                ->where('code_country', $code_country)
                ->whereNull('deleted_at'),
                'can_add_half_hour' => 'nullable'
            ];
        }

        if (checkUser('lecturer')) {
            $rules['id_image']  = 'mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
            $rules['job_proof_image']  = 'mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
            $rules['cv_file']  = 'mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        }


        return $rules;
    }
}
