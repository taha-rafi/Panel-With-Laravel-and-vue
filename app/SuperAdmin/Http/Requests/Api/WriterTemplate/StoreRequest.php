<?php

namespace App\SuperAdmin\Http\Requests\Api\WriterTemplate;

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
            'writer_category_id'    => 'required',
            'name'    => 'required',
            'description'    => 'required',
            'status'    => 'required',
            'prompt_text'    => 'required',
        ];

        return $rules;
    }
}
