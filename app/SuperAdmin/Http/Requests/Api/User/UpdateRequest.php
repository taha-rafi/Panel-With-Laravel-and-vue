<?php

namespace App\SuperAdmin\Http\Requests\Api\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;

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
		$convertedId = Hashids::decode($this->route('user'));
		$id = $convertedId[0];

		$rules = [
			'name' => 'required',
			'phone'    => [
				'numeric',
				Rule::unique('users', 'phone')->where(function ($query) {
					return $query->where('user_type', 'staff_members')
						->where('user_type', 'super_admins');
				})->ignore($id)
			],
			'email'    => [
				'required', 'email',
				Rule::unique('users', 'email')->where(function ($query) {
					return $query->where('user_type', 'staff_members')
						->where('user_type', 'super_admins');
				})->ignore($id)
			],
			'status' => 'required',
		];

		if ($this->password != '') {
			$rules['password'] = 'required|min:8';
		}

		return $rules;
	}
}
