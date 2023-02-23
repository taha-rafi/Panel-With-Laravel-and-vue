<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\PaypalIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\PaypalUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\StripeIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\StripeUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\RazorpayIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\RazorpayUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\PaystackIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\PaystackUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\MollieIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\MollieUpdateRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\AuthorizeIndexRequest;
use App\SuperAdmin\Http\Requests\Api\PaymentSettings\AuthorizeUpdateRequest;
use App\SuperAdmin\Models\GlobalSettings;
use Examyou\RestAPI\ApiResponse;

class PaymentSettingsController extends ApiBaseController
{
    public function getPaypal(PaypalIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'paypal')
            ->first();

        $settingData = [
            'paypal_client_id' => $settings->credentials['paypal_client_id'],
            'paypal_secret' => $settings->credentials['paypal_secret'],
            'paypal_mode' => $settings->credentials['paypal_mode'],
            'paypal_status' => $settings->credentials['paypal_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
                'webhook_url' => route('webhook.save-paypal-invoices')
            ]
        );
    }

    public function updatePaypal(PaypalUpdateRequest $request)
    {
        $settingData = [
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_secret' => $request->paypal_secret,
            'paypal_mode' => $request->paypal_mode,
            'paypal_status' => $request->paypal_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'paypal')
            ->update([
                'credentials' => $settingData,
                'status' => $request->paypal_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getStripe(StripeIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'stripe')
            ->first();

        $settingData = [
            'stripe_api_key' => $settings->credentials['stripe_api_key'],
            'stripe_api_secret' => $settings->credentials['stripe_api_secret'],
            'stripe_webhook_key' => $settings->credentials['stripe_webhook_key'],
            'stripe_status' => $settings->credentials['stripe_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
                'webhook_url' => route('webhook.save-stripe-invoices')
            ]
        );
    }

    public function updateStripe(StripeUpdateRequest $request)
    {
        $settingData = [
            'stripe_api_key' => $request->stripe_api_key,
            'stripe_api_secret' => $request->stripe_api_secret,
            'stripe_webhook_key' => $request->stripe_webhook_key,
            'stripe_status' => $request->stripe_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'stripe')
            ->update([
                'credentials' => $settingData,
                'status' => $request->stripe_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getRazorpay(RazorpayIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'razorpay')
            ->first();

        $settingData = [
            'razorpay_key' => $settings->credentials['razorpay_key'],
            'razorpay_secret' => $settings->credentials['razorpay_secret'],
            'razorpay_webhook_secret' => $settings->credentials['razorpay_webhook_secret'],
            'razorpay_status' => $settings->credentials['razorpay_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
                'webhook_url' => route('webhook.save-razorpay-invoices')
            ]
        );
    }

    public function updateRazorpay(RazorpayUpdateRequest $request)
    {
        $settingData = [
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,
            'razorpay_webhook_secret' => $request->razorpay_webhook_secret,
            'razorpay_status' => $request->razorpay_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'razorpay')
            ->update([
                'credentials' => $settingData,
                'status' => $request->razorpay_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getPaystack(PaystackIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'paystack')
            ->first();

        $settingData = [
            'paystack_client_id' => $settings->credentials['paystack_client_id'],
            'paystack_secret' => $settings->credentials['paystack_secret'],
            'paystack_merchant_email' => $settings->credentials['paystack_merchant_email'],
            'paystack_status' => $settings->credentials['paystack_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
                'webhook_url' => route('webhook.save-paystack-invoices'),
                'callback_url' => ''
            ]
        );
    }

    public function updatePaystack(PaystackUpdateRequest $request)
    {
        $settingData = [
            'paystack_client_id' => $request->paystack_client_id,
            'paystack_secret' => $request->paystack_secret,
            'paystack_merchant_email' => $request->paystack_merchant_email,
            'paystack_status' => $request->paystack_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'paystack')
            ->update([
                'credentials' => $settingData,
                'status' => $request->paystack_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getMollie(MollieIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'mollie')
            ->first();

        $settingData = [
            'mollie_api_key' => $settings->credentials['mollie_api_key'],
            'mollie_status' => $settings->credentials['mollie_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
            ]
        );
    }

    public function updateMollie(MollieUpdateRequest $request)
    {
        $settingData = [
            'mollie_api_key' => $request->mollie_api_key,
            'mollie_status' => $request->mollie_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'mollie')
            ->update([
                'credentials' => $settingData,
                'status' => $request->mollie_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }

    public function getAuthorize(AuthorizeIndexRequest $request)
    {
        $settings = GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'authorize')
            ->first();

        $settingData = [
            'authorize_api_login_id' => $settings->credentials['authorize_api_login_id'],
            'authorize_transaction_key' => $settings->credentials['authorize_transaction_key'],
            'authorize_signature_key' => $settings->credentials['authorize_signature_key'],
            'authorize_environment' => $settings->credentials['authorize_environment'],
            'authorize_status' => $settings->credentials['authorize_status'],
        ];

        return ApiResponse::make(
            'Success',
            [
                'data' => $settingData,
                'webhook_url' => route('webhook.save-authorize-invoices')
            ]
        );
    }

    public function updateAuthorize(AuthorizeUpdateRequest $request)
    {
        $settingData = [
            'authorize_api_login_id' => $request->authorize_api_login_id,
            'authorize_transaction_key' => $request->authorize_transaction_key,
            'authorize_signature_key' => $request->authorize_signature_key,
            'authorize_environment' => $request->authorize_environment,
            'authorize_status' => $request->authorize_status,
        ];

        GlobalSettings::where('setting_type', 'payment_settings')
            ->where('name_key', 'authorize')
            ->update([
                'credentials' => $settingData,
                'status' => $request->authorize_status == 'active' ? 1 : 0
            ]);

        return ApiResponse::make('Success', []);
    }
}
