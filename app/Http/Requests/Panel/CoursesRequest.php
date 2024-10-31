<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoursesRequest extends FormRequest
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
        $rules['image']       = 'required';
        $rules['cover_image'] = 'required';
        $rules['type']        = 'required:in:recorded,live';
        $rules['image']       = 'required';
        $rules['user_id']     = 'required';
        $rules['material_id'] = 'required';
        //   $rules['start_date'] = 'required|date:Y-m-d H:i:s';
        //  $rules['end_date'] = 'required|date|after:start_date';
        foreach (locales() as $key => $language) {
            $rules['title_' . $key]       = 'required';
            $rules['description_' . $key] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        $messages['image.required']       = 'الصورة مطلوبة';
        $messages['cover_image.required'] = 'الغلاف مطلوب';
        $messages['type.required']        = 'النوع مطلوب';
        $messages['type.in']              = ' النوع لابد ان يكونrecorded او live';
        $messages['user_id.required']     = 'رقم المستخدم مطلوب';
        $messages['material_id']          = 'المادة مطلوبة';
        foreach (locales() as $key => $language) {
            $messages['title_' . $key . '.required']       = "العنوان مطلوب ($key)";
            $messages['description_' . $key . '.required'] = "الوصف مطلوب ($key)";
        }
        return $messages;
    }
}
