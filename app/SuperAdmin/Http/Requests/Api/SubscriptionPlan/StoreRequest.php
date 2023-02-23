<?php

namespace App\SuperAdmin\Http\Requests\Api\SubscriptionPlan;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'    => 'required',
            'description'    => 'required',
            'max_characters'    => 'required|integer',
            'annual_price'    => 'required',
            'monthly_price'    => 'required',
        ];

        return $rules;
    }
}
