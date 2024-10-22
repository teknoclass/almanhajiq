<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class LecturerPricingSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'online_group_min_no' => 'nullable|integer|min:0',
            'online_group_max_no' => 'nullable|integer|min:' . $this->input('online_group_min_no'),
            'online_group_price' => 'nullable|numeric|min:0',
            'offline_group_min_no' => 'nullable|integer|min:0',
            'offline_group_max_no' => 'nullable|integer|min:' . $this->input('offline_group_min_no'),
            'offline_group_price' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
{
    return [
        // 'online_price.required' => 'حقل السعر للدروس الأونلاين مطلوب.',
      
    ];
}

}
