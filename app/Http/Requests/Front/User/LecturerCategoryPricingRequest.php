<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class LecturerCategoryPricingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {

        return [
            'category_id'          => 'required', 'exists:category_translations,id',
            'online_price'         => 'required|numeric|min:0',
            'online_discount'      => 'nullable|numeric|min:0|max:100',
            'offline_price'        => 'nullable|numeric|min:0',
            'offline_discount'     => 'nullable|numeric|min:0|max:100',
            'accept_group'         => 'sometimes',
            'online_group_min_no'  => 'required_if:accept_group,1|integer|min:0|nullable',
            'online_group_max_no'  => 'required_if:accept_group,1|integer|min:0|nullable|gte:online_group_min_no',
            'online_group_price'   => 'required_if:accept_group,1|numeric|min:0|nullable',
            // 'offline_group_min_no' => 'required_if:accept_group,1|integer|min:0|nullable',
            // 'offline_group_max_no' => 'required_if:accept_group,1|integer|min:0|nullable|gte:offline_group_min_no',
            // 'offline_group_price'  => 'required_if:accept_group,1|numeric|min:0|nullable',

        ];
    }

    public function messages()
    {
        return [
            'category_id.required'             => 'حقل اسم الماده مطلوب.',
            'category_id.exists'               => 'الماده المحددة غير موجودة.',
            'online_price.required'            => 'حقل السعر أونلاين مطلوب.',
            'online_price.numeric'             => 'يجب أن يكون السعر أونلاين قيمة عددية.',
            'online_price.min'                 => 'يجب أن يكون السعر أونلاين على الأقل 0.',
            'online_discount.numeric'          => 'يجب أن يكون الخصم أونلاين قيمة عددية.',
            'online_discount.min'              => 'يجب أن يكون الخصم أونلاين على الأقل 0.',
            'online_discount.max'              => 'يجب أن لا يزيد الخصم أونلاين عن 100.',
            'offline_price.required'           => 'حقل السعر أوفلاين مطلوب.',
            'offline_price.numeric'            => 'يجب أن يكون السعر أوفلاين قيمة عددية.',
            'offline_price.min'                => 'يجب أن يكون السعر أوفلاين على الأقل 0.',
            'offline_discount.numeric'         => 'يجب أن يكون الخصم أوفلاين قيمة عددية.',
            'offline_discount.min'             => 'يجب أن يكون الخصم أوفلاين على الأقل 0.',
            'offline_discount.max'             => 'يجب أن لا يزيد الخصم أوفلاين عن 100.',
            'accept_group.required'            => 'حقل قبول المجموعة مطلوب.',
            'online_group_min_no.required_if'  => 'حقل الحد الأدنى للمجموعة أونلاين مطلوب عندما يتم قبول المجموعة.',
            'online_group_min_no.integer'      => 'يجب أن يكون الحد الأدنى للمجموعة أونلاين قيمة صحيحة.',
            'online_group_min_no.min'          => 'يجب أن يكون الحد الأدنى للمجموعة أونلاين على الأقل 0.',
            'online_group_max_no.required_if'  => 'حقل الحد الأقصى للمجموعة أونلاين مطلوب عندما يتم قبول المجموعة.',
            'online_group_max_no.integer'      => 'يجب أن يكون الحد الأقصى للمجموعة أونلاين قيمة صحيحة.',
            'online_group_max_no.min'          => 'يجب أن يكون الحد الأقصى للمجموعة أونلاين على الأقل 0.',
            'online_group_max_no.gte'          => 'يجب أن يكون الحد الأقصى للمجموعة أونلاين أكبر من أو يساوي الحد الأدنى.',
            'online_group_price.required_if'   => 'حقل السعر للمجموعة أونلاين مطلوب عندما يتم قبول المجموعة.',
            'online_group_price.numeric'       => 'يجب أن يكون السعر للمجموعة أونلاين قيمة عددية.',
            'online_group_price.min'           => 'يجب أن يكون السعر للمجموعة أونلاين على الأقل 0.',
            'offline_group_min_no.required_if' => 'حقل الحد الأدنى للمجموعة أوفلاين مطلوب عندما يتم قبول المجموعة.',
            'offline_group_min_no.integer'     => 'يجب أن يكون الحد الأدنى للمجموعة أوفلاين قيمة صحيحة.',
            'offline_group_min_no.min'         => 'يجب أن يكون الحد الأدنى للمجموعة أوفلاين على الأقل 0.',
            'offline_group_max_no.required_if' => 'حقل الحد الأقصى للمجموعة أوفلاين مطلوب عندما يتم قبول المجموعة.',
            'offline_group_max_no.integer'     => 'يجب أن يكون الحد الأقصى للمجموعة أوفلاين قيمة صحيحة.',
            'offline_group_max_no.min'         => 'يجب أن يكون الحد الأقصى للمجموعة أوفلاين على الأقل 0.',
            'offline_group_max_no.gte'         => 'يجب أن يكون الحد الأقصى للمجموعة أوفلاين أكبر من أو يساوي الحد الأدنى.',
            'offline_group_price.required_if'  => 'حقل السعر للمجموعة أوفلاين مطلوب عندما يتم قبول المجموعة.',
            'offline_group_price.numeric'      => 'يجب أن يكون السعر للمجموعة أوفلاين قيمة عددية.',
            'offline_group_price.min'          => 'يجب أن يكون السعر للمجموعة أوفلاين على الأقل 0.',
        ];
    }
}
