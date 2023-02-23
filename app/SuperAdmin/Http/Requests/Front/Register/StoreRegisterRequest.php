<?php

namespace App\SuperAdmin\Http\Requests\Front\Register;

use App\SuperAdmin\Http\Requests\Front\FrontCoreRequest;

class StoreRegisterRequest extends FrontCoreRequest
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
        return [
            'company_name'     => 'required',
            'company_email'     => ['required', 'email', 'unique:users,email'],
            'password'     => 'required|min:8',
            'confirm_password'     => 'required|same:password',
            'condition'     => 'required',
        ];
    }
}
