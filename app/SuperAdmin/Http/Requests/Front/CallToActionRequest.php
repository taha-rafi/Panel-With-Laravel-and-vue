<?php

namespace App\SuperAdmin\Http\Requests\Front;

use App\SuperAdmin\Http\Requests\Front\FrontCoreRequest;

class CallToActionRequest extends FrontCoreRequest
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
            'action_email'     => 'required|email',
        ];
    }
}
