<?php

namespace App\SuperAdmin\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('stripe', function (Builder $builder) {
            $builder->where('subscriptions.payment_method', 'stripe');
        });
    }

    public function scopePaypal($query)
    {
        return $query->where('payment_method', 'paypal');
    }

    // public function scopeStripe($query)
    // {
    //     return $query->where('payment_method', 'stripe');
    // }

    public function scopeRazorpay($query)
    {
        return $query->where('payment_method', 'razorpay');
    }

    public function scopePaystack($query)
    {
        return $query->where('payment_method', 'paystack');
    }

    public function scopeMollie($query)
    {
        return $query->where('payment_method', 'mollie');
    }

    public function scopeAuthorize($query)
    {
        return $query->where('payment_method', 'authorize');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
