<?php

namespace App\SuperAdmin\Http\Requests\Api\WebsiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteSettingsUpdateRequest extends FormRequest
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
			'lang_key'    => 'required',
			'header_title'    => 'required',
		];

		if ($this->header_login_button_show != '' && $this->header_login_button_show == '1') {
			$rules['header_login_button_text'] = 'required';
		}

		if ($this->header_register_button_show != '' && $this->header_register_button_show == '1') {
			$rules['header_register_button_show'] = 'required';
		}

		return $rules;
	}
}
