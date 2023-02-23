<?php

namespace App\SuperAdmin\Http\Requests\Api\PaymentSettings;

use Illuminate\Foundation\Http\FormRequest;

class MollieUpdateRequest extends FormRequest
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
			'mollie_api_key'    => 'required',
			'mollie_status'    => 'required',
		];

		return $rules;
	}
}
