<?php

namespace App\SuperAdmin\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubmitOfflinePaymentRequest extends FormRequest
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
            'offline_payment_mode_id' => 'required',
            'proof_document' => 'required',
            'submit_description' => 'required',
            'subscription_plan_id' => 'required',
            'plan_type' => 'required',
        ];

        return $rules;
    }
}
