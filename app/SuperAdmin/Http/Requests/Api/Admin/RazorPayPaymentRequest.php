<?php

namespace App\SuperAdmin\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;

class RazorPayPaymentRequest extends FormRequest
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
        $rules = [
            'plan_id' => 'required',
            'plan_type' => 'required',
        ];

        return $rules;
    }
}
