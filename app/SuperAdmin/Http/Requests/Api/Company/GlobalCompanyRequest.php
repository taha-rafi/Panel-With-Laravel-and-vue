<?php

namespace App\SuperAdmin\Http\Requests\Api\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;

class GlobalCompanyRequest extends FormRequest
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
            'short_name'    => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'timezone' => 'required',
            'currency_id' => 'required',
        ];

        return $rules;
    }
}
