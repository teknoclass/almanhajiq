<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfitsWithdrawalRequestRequest  extends FormRequest
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
        $rules['amount']  = 'required';
        $rules['withdrawal_method']  = 'required:in:cash,bank_transfer';
        $rules['details']  = 'required|string|min:4';

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'details.required' => 'نرجوا منكم كتابة التفاصيل',
        ];

        return $messages;
    }
}
