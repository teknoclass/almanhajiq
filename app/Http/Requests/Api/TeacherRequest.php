<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
        $max_size_file = 1024 * 3;

        $rules['name']                     = 'required|string|max:255';
        $rules['email']                    = 'required|email|'. Rule::unique('join_as_teacher_requests')->whereNotNull('email')->whereNull('deleted_at');
        $rules['mobile']                   = 'required|' . Rule::unique('join_as_teacher_requests')->whereNotNull('mobile')->whereNull('deleted_at');
        $rules['about']                    = 'required|string|max:255';
        $rules['gender']                   = ['required'];
        $rules['specialization_id']            = ['required' ,'exists:categories,id'];
        $rules['material_id']            = ['required' ,'exists:categories,id'];
        $rules['certificate_id']           = ['required' ,'exists:categories,id'];
        $rules['country_id']               = ['required' ,'exists:categories,id'];
        $rules['code_country']               = ['required'];
        $rules['city']                     = 'required|string|max:255';
        $rules['id_image']                 = 'required|mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        $rules['job_proof_image']          = 'mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        $rules['cv_file']                  = 'required|mimes:jpeg,png,pdf,jpg|max:' . $max_size_file;
        $rules['timezone']                  = 'required|string|max:255';

        return $rules;
    }

}
