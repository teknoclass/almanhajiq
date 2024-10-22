<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class MarketersJoiningRequestsRequest extends FormRequest
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
        $rules['status'] = 'required|in:under_review,acceptable,unacceptable';

        $rules['coupon_id'] = 'required_if:status,==,acceptable';
        $rules['marketer_amount_type'] = 'required_if:status,==,acceptable';
        $rules['marketer_amount'] = 'required_if:status,==,acceptable';
        $rules['marketer_amount_of_registration'] = 'required_if:status,==,acceptable';

        return $rules;
    }
}
