<?php

namespace App\SuperAdmin\Traits;

use App\Scopes\CompanyScope;
use App\SuperAdmin\Models\GlobalSettings;
use Illuminate\Support\Facades\Config;

trait StripeSettings
{
    public function setStripConfigs()
    {
        $stripeSettings = GlobalSettings::withoutGlobalScope(CompanyScope::class)
            ->where('setting_type', 'payment_settings')
            ->where('name_key', 'stripe')
            ->first();
        $settings = (object) $stripeSettings->credentials;

        $key       = ($settings->stripe_api_key) ? $settings->stripe_api_key : env('STRIPE_KEY');
        $apiSecret = ($settings->stripe_api_secret) ? $settings->stripe_api_secret : env('STRIPE_SECRET');
        $webhookKey = ($settings->stripe_webhook_key) ? $settings->stripe_webhook_key : env('STRIPE_WEBHOOK_SECRET');

        Config::set('cashier.key', $key);
        Config::set('cashier.secret', $apiSecret);
        Config::set('cashier.webhook.secret', $webhookKey);
    }
}
