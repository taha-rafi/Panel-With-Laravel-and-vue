<?php

use Illuminate\Support\Facades\Route;

// Landing Website
Route::group(['namespace' => 'Front'], function () {

    Route::any('/save-authorize-invoices', ['as' => 'webhook.save-authorize-invoices', 'uses' => 'PaymentWebhookController@saveAuthorizeInvoices']);
    Route::post('/save-stripe-invoices', ['as' => 'webhook.save-stripe-invoices', 'uses' => 'PaymentWebhookController@saveStripeInvoices']);
    Route::post('/save-paypal-invoices', ['as' => 'webhook.save-paypal-invoices', 'uses' => 'PaymentWebhookController@verifyBillingIPN']);
    Route::post('/save-razorpay-invoices', ['as' => 'webhook.save-razorpay-invoices', 'uses' => 'RazorpayWebhookController@saveInvoices']);
    Route::post('/save-paystack-invoices', ['as' => 'webhook.save-paystack-invoices', 'uses' => 'PaymentWebhookController@savePaystackInvoices']);

    Route::group(['middleware' => ['web']], function () {
        Route::get('/', ['as' => 'front.index', 'uses' => 'HomeController@index']);
        Route::get('/verify/{code}', ['as' => 'front.register.verify', 'uses' => 'HomeController@verifyRegister']);
        Route::post('/save-register', ['as' => 'front.register.save', 'uses' => 'HomeController@saveRegister']);
        Route::get('/register', ['as' => 'front.register', 'uses' => 'HomeController@register']);
        Route::get('/page/{slug}', ['as' => 'front.page', 'uses' => 'HomeController@page']);
        Route::post('/submit-contact-form', ['as' => 'front.submit-contact-form', 'uses' => 'HomeController@submitContactForm']);
        Route::get('/pricing', ['as' => 'front.pricing', 'uses' => 'HomeController@pricing']);
        Route::get('/contact', ['as' => 'front.contact', 'uses' => 'HomeController@contact']);
        Route::get('/features', ['as' => 'front.features', 'uses' => 'HomeController@features']);
        Route::post('/call-to-action', ['as' => 'front.call-to-action', 'uses' => 'HomeController@callToAction']);
        Route::post('/change-language', ['as' => 'front.change-language', 'uses' => 'HomeController@changeLanguage']);
    });
});
