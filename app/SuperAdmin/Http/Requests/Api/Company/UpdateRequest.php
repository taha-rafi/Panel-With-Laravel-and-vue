<?php

namespace App\SuperAdmin\Http\Requests\Api\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $convertedId = Hashids::decode($this->route('company'));
        $id = $convertedId[0];

        $company = Company::select('admin_id')->withoutGlobalScope('company')->find($id);

        $rules = [
            'name'    => 'required',
            'short_name'    => 'required',
            'email' => 'required|email|unique:companies,email,' . $id,
            'phone' => 'required|numeric|unique:companies,phone,' . $id,
            'timezone' => 'required',
            'status' => 'required',
            'user_email'    => [
                'required', 'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->where('user_type', 'staff_members')
                        ->orWhere('user_type', 'super_admins');
                })->ignore($company->admin_id)
            ],
        ];

        if ($this->has('user_password') && $this->user_password != '') {
            $rules['user_password'] = 'required|min:8';
        }

        return $rules;
    }
}
