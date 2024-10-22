<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponsRequest  extends FormRequest
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
        $rules['title'] = 'required';
        $rules['amount_type'] = 'required';
        $rules['amount'] = 'required';
        
        if (request()->route('id')) {
            $rules['code'] = 'required|regex:/^\S*$/u|' . Rule::unique('coupons')->whereNotNull('code')->whereNot('id', request('id'));
        } else {
            $rules['code'] = 'required|regex:/^\S*$/u|' . Rule::unique('coupons')->whereNotNull('code');
        }

        return $rules;
    }
}
