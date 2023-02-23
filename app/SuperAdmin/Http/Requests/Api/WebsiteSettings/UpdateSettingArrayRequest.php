<?php

namespace App\SuperAdmin\Http\Requests\Api\WebsiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingArrayRequest extends FormRequest
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

    public function validationData()
    {
        return $this->form_data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $requestType = $this->request_type;
        $settingType = $this->setting_type;
        $rules = [];

        if ($requestType == 'add_edit') {
            if ($settingType == 'website_clients') {
                $rules = [
                    'lang_key'    => 'required',
                    'name'    => 'required',
                ];
            } else if ($settingType == 'website_testimonials') {
                $rules = [
                    'lang_key'    => 'required',
                    'name'    => 'required',
                    'comment'    => 'required',
                    'rating'    => 'required|integer|min:1',
                ];
            } else if ($settingType == 'website_features') {
                $rules = [
                    'lang_key'    => 'required',
                    'title'    => 'required',
                    'description'    => 'required',
                    'image'    => 'required',
                ];
            } else if ($settingType == 'website_faqs') {
                $rules = [
                    'lang_key'    => 'required',
                    'question'    => 'required',
                    'answer'    => 'required',
                ];
            } else if ($settingType == 'footer_pages') {
                $rules = [
                    'lang_key'    => 'required',
                    'title'    => 'required',
                    'slug'    => 'required',
                    'page_content'    => 'required',
                    'seo_keywords'    => 'required',
                    'seo_description'    => 'required',
                ];
            } else if ($settingType == 'website_seo') {
                $rules = [
                    'page_key'    => 'required',
                    'seo_title'    => 'required',
                    'seo_author'    => 'required',
                    'seo_keywords'    => 'required',
                    'seo_description'    => 'required',
                    'seo_image'    => 'required',
                ];
            }
        }

        return $rules;
    }
}
