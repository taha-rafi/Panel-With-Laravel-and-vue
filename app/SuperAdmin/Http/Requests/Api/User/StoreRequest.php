<?php

namespace App\SuperAdmin\Http\Requests\Api\User;

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
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'phone' => 'required|numeric|unique:users,phone',
			'password' => 'required|min:8',
			'status' => 'required',
		];

		return $rules;
	}
}
