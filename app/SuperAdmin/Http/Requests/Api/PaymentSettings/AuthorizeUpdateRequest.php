<?php

namespace App\SuperAdmin\Http\Requests\Api\PaymentSettings;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizeUpdateRequest extends FormRequest
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
			'authorize_api_login_id'    => 'required',
			'authorize_transaction_key'    => 'required',
			'authorize_signature_key'    => 'required',
			'authorize_environment'    => 'required',
			'authorize_status'    => 'required',
		];

		return $rules;
	}
}
