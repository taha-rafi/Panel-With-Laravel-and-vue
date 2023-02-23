<?php

namespace App\SuperAdmin\Http\Requests\Api\OfflineRequest;

use Illuminate\Foundation\Http\FormRequest;

class RejectOfllineRequest extends FormRequest
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
            'offline_request_id' => 'required',
        ];
    }
}
