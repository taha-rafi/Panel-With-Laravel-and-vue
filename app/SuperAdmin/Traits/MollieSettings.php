<?php

namespace App\SuperAdmin\Traits;

use App\SuperAdmin\Models\GlobalSettings;
use Illuminate\Support\Facades\Config;

trait MollieSettings
{
    public function setMollieConfigs()
    {
        $mollieSettings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'mollie')
            ->first();
        $settings = (object) $mollieSettings->credentials;

        $key       = ($settings->mollie_api_key) ? $settings->mollie_api_key : env('MOLLIE_KEY');
        Config::set('mollie.key', $key);
    }
}
