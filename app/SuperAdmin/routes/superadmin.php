<?php

use Examyou\RestAPI\Facades\ApiRoute;

// Admin Subscription Route
ApiRoute::group(['namespace' => 'App\SuperAdmin\Http\Controllers\Api\Admin', 'middleware' => ['api.permission.check', 'api.auth.check']], function () {

    // Offline
    ApiRoute::post('submit-offline-request', ['as' => 'admin.extra.offline.submit-offline-request', 'uses' => 'AdminOfflineRequestController@submitOfflineRequest']);
    ApiRoute::resource('offline-requests', 'AdminOfflineRequestController', [
        'as' => 'api.extra',
        'only' => ['index']
    ]);

    // Paypal
    ApiRoute::get('paypal-invoice-download/{id}', ['as' => 'admin.extra.paypal.invoice-download', 'uses' => 'AdminPaypalController@paypalInvoiceDownload']);
    ApiRoute::get('paypal-recurring', ['as' => 'admin.extra.paypal-recurring', 'uses' => 'AdminPaypalController@payWithPaypalRecurrring']);
    ApiRoute::get('paypal/{planId}/{type}', ['as' => 'admin.extra.paypal', 'uses' => 'AdminPaypalController@paymentWithpaypal']);

    ApiRoute::post('razorpay-subscription', ['as' => 'api.extra.razorpay.subscription', 'uses' => 'RazorpaySubscriptionController@razorpaySubscription']);
    ApiRoute::post('razorpay-payment', ['as' => 'api.extra.razorpay.payment', 'uses' => 'RazorpaySubscriptionController@razorpayPayment']);

    // Stripe
    ApiRoute::post('stripe-payment', ['as' => 'api.extra.stripe.payment', 'uses' => 'AdminStripeController@stripePayment']);

    ApiRoute::get('all-payment-methods', ['as' => 'api.extra.subscription-plan.payment-methods', 'uses' => 'AdminSubscriptionController@allPaymentMethodSettings']);
    ApiRoute::get('all-subscription-plans', ['as' => 'api.extra.subscription-plan.all', 'uses' => 'AdminSubscriptionController@allSubscriptionPlans']);
    ApiRoute::get('subscription-plan-details', ['as' => 'api.extra.subscription-plan.details', 'uses' => 'AdminSubscriptionController@subscribePlanDetails']);
    ApiRoute::resource('subscription-transcations', 'AdminSubscriptionController', [
        'as' => 'api.extra',
        'only' => ['index']
    ]);
});

// Superadmin
ApiRoute::group(['namespace' => 'App\SuperAdmin\Http\Controllers\Api', 'prefix' => 'superadmin', 'middleware' => ['api.superadmin.check', 'api.superadmin.permission.check']], function () {
    $options = [
        'as' => 'api.superadmin'
    ];

    ApiRoute::resource('writer-categories', 'WriterCategoryController', $options);
    ApiRoute::resource('writer-templates', 'WriterTemplateController', $options);

    // For White Label Logo
    ApiRoute::get('default-logo-details', ['as' => 'api.superadmin.default-logo-details', 'uses' => 'DashboardController@defaultLogoDetails']);
    ApiRoute::post('upload-default-logo', ['as' => 'api.superadmin.upload-default-logo', 'uses' => 'DashboardController@uploadDefaultLogo']);
    ApiRoute::post('white-label-completed', ['as' => 'api.superadmin.white-label-completed', 'uses' => 'DashboardController@whiteLabelCompleted']);

    // Offline Requests
    ApiRoute::post('offline-requests/reject', ['as' => 'api.superadmin.offline-requests.reject', 'uses' => 'OfflineRequestController@rejectOfflineRequest']);
    ApiRoute::post('offline-requests/approve', ['as' => 'api.superadmin.offline-requests.approve', 'uses' => 'OfflineRequestController@approveOfflineRequest']);
    ApiRoute::resource('offline-requests', 'OfflineRequestController', ['as' => 'api.superadmin', 'only' => ['index']]);

    // Commpanies
    ApiRoute::post('companies/change-subscription-plan', ['as' => 'api.superadmin.companies.change-subscription-plan', 'uses' => 'CompanyController@changeSubscriptionPlan']);
    ApiRoute::resource('companies', 'CompanyController', $options);

    ApiRoute::get('dashboard', ['as' => 'api.superadmin.dashboard', 'uses' => 'DashboardController@dashboard']);

    ApiRoute::get('global-company/website-lang', ['as' => 'api.superadmin.global-company.website-lang', 'uses' => 'GlobalCompanyController@getWebsiteLang']);
    ApiRoute::resource('global-company', 'GlobalCompanyController', ['as' => 'api.superadmin', 'only' => ['update']]);
    // ApiRoute::resource('langs', 'LangsController', $options);
    ApiRoute::resource('currencies', 'CurrencyController', $options);
    ApiRoute::resource('users', 'UsersController', $options);
    ApiRoute::resource('subscription-plans', 'SubscriptionPlanController', $options);
    ApiRoute::resource('offline-payment-modes', 'OfflinePaymentModeController', $options);

    ApiRoute::resource('payment-transcations', 'PaymentTranscationController', ['as' => 'api.superadmin', 'only' => ['index']]);

    ApiRoute::get('trial-plan', ['as' => 'api.subscription-plans.trial', 'uses' => 'SubscriptionPlanController@trailPlan']);

    ApiRoute::group(['prefix' => 'website-settings'], function () {
        ApiRoute::post('settings/update', ['as' => 'api.website-settings.settings.update', 'uses' => 'WebsiteSettingsController@updateSettingArray']);
        ApiRoute::get('settings', ['as' => 'api.website-settings.settings.index', 'uses' => 'WebsiteSettingsController@getSettings']);
        ApiRoute::post('website/update', ['as' => 'api.website-settings.website.update', 'uses' => 'WebsiteSettingsController@updateWebisteSettings']);
        ApiRoute::get('website', ['as' => 'api.website-settings.website.index', 'uses' => 'WebsiteSettingsController@getWebsiteSettings']);
    });

    ApiRoute::group(['prefix' => 'payment-settings'], function () {
        ApiRoute::post('paypal/update', ['as' => 'api.payment-settings.paypal.update', 'uses' => 'PaymentSettingsController@updatePaypal']);
        ApiRoute::get('paypal', ['as' => 'api.payment-settings.paypal.index', 'uses' => 'PaymentSettingsController@getPaypal']);
        ApiRoute::post('stripe/update', ['as' => 'api.payment-settings.stripe.update', 'uses' => 'PaymentSettingsController@updateStripe']);
        ApiRoute::get('stripe', ['as' => 'api.payment-settings.stripe.index', 'uses' => 'PaymentSettingsController@getStripe']);
        ApiRoute::post('razorpay/update', ['as' => 'api.payment-settings.razorpay.update', 'uses' => 'PaymentSettingsController@updateRazorpay']);
        ApiRoute::get('razorpay', ['as' => 'api.payment-settings.razorpay.index', 'uses' => 'PaymentSettingsController@getRazorpay']);
        ApiRoute::post('paystack/update', ['as' => 'api.payment-settings.paystack.update', 'uses' => 'PaymentSettingsController@updatePaystack']);
        ApiRoute::get('paystack', ['as' => 'api.payment-settings.paystack.index', 'uses' => 'PaymentSettingsController@getPaystack']);
        ApiRoute::post('mollie/update', ['as' => 'api.payment-settings.mollie.update', 'uses' => 'PaymentSettingsController@updateMollie']);
        ApiRoute::get('mollie', ['as' => 'api.payment-settings.mollie.index', 'uses' => 'PaymentSettingsController@getMollie']);
        ApiRoute::post('authorize/update', ['as' => 'api.payment-settings.authorize.update', 'uses' => 'PaymentSettingsController@updateAuthorize']);
        ApiRoute::get('authorize', ['as' => 'api.payment-settings.authorize.index', 'uses' => 'PaymentSettingsController@getAuthorize']);
    });
});
