<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/download-percentage",
        '/save-authorize-invoices',
        '/save-stripe-invoices',
        '/save-paypal-invoices',
        '/save-razorpay-invoices',
        '/save-paystack-invoices',
        "langs/download/*"
    ];
}
