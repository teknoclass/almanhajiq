<?php

namespace App\Http\Requests\Panel;

use App\Models\Courses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddStudentCourseRequest extends FormRequest
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


        $rules['course_id']='required';
        $rules['user_id']='required';



        return $rules;
    }
}
