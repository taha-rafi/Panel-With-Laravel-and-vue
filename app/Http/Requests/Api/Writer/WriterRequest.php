<?php

namespace App\Http\Requests\Api\Writer;

use Illuminate\Foundation\Http\FormRequest;

class WriterRequest extends FormRequest
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
        $formFields = $this->form_fields;

        $rules = [
            'max_result_length' => 'required|integer',
            'language' => 'required'
        ];

        foreach ($formFields as $formField) {
            if ($formField['value'] == "") {
                $rules[$formField['slug']] = 'required';
            }
        }

        return $rules;
    }
}
