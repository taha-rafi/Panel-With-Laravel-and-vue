<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Classes\Common;
use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\WebsiteSettings\WebsiteSettingsIndexRequest;
use App\SuperAdmin\Http\Requests\Api\WebsiteSettings\WebsiteSettingsUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\WebsiteSettings\UpdateSettingArrayRequest;
use App\SuperAdmin\Models\GlobalSettings;
use Examyou\RestAPI\ApiResponse;

class WebsiteSettingsController extends ApiBaseController
{
    public function websiteSetting()
    {
        $request = request();

        $langKey = $request->has('lang_key') ? $request->lang_key : "en";

        $settings = GlobalSettings::where('setting_type', 'website_settings')
            ->where('name_key', $langKey)
            ->first();

        $settingData = $settings->credentials;

        // Generating Image Url
        // $settingData = Common::addWebsiteImageUrl($settingData, 'website_logo');
        // $settingData = Common::addWebsiteImageUrl($settingData, 'header_image');
        // $settingData = Common::addWebsiteImageUrl($settingData, 'header_background_image');

        return $settingData;
    }

    public function getWebsiteSettings(WebsiteSettingsIndexRequest $request)
    {
        return ApiResponse::make(
            'Success',
            [
                'data' => $this->websiteSetting(),
            ]
        );
    }

    public function updateWebisteSettings(WebsiteSettingsUpdateRequest $request)
    {
        $langKey = $request->lang_key;

        GlobalSettings::where('setting_type', 'website_settings')
            ->where('name_key', $langKey)
            ->update([
                'credentials' => $request->all()
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getSettings(WebsiteSettingsIndexRequest $request)
    {
        $request = request();

        $langKey = $request->has('lang_key') ? $request->lang_key : "en";
        $settingType = $request->setting_type;

        $settings = GlobalSettings::where('setting_type', $settingType)
            ->where('name_key', $langKey)
            ->first();

        $allResults = $settings->credentials;

        // Generating Image Url
        if ($settingType == 'website_clients' || $settingType == 'website_features') {
            foreach ($allResults as &$allResult) {
                if ($settingType == 'website_clients') {
                    $allResult = Common::addWebsiteImageUrl($allResult, 'logo');
                } else if ($settingType == 'website_features') {
                    $allResult = Common::addWebsiteImageUrl($allResult, 'image');
                }
            }
        }

        return ApiResponse::make(
            'Success',
            [
                'data' => $allResults,

            ]
        );
    }

    public function updateSettingArray(UpdateSettingArrayRequest $request)
    {
        $langKey = $request->lang_key;
        $settingType = $request->setting_type;

        GlobalSettings::where('setting_type', $settingType)
            ->where('name_key', $langKey)
            ->update([
                'credentials' => $request->all_form_data
            ]);

        return ApiResponse::make('Success', [
            'lang' => $langKey,
            'settingType' => $settingType,
        ]);
    }
}
