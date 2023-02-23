<?php

namespace App\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySettings extends Model
{
    protected $table = 'payment_gateway_settings';

    protected $appends = ['show_pay'];

    public function getShowPayAttribute()
    {
        return $this->attributes['paypal_status'] == 'active' || $this->attributes['stripe_status'] == 'active' || $this->attributes['paystack_status'] == 'active' || $this->attributes['razorpay_status'] == 'active' || $this->attributes['mollie_status'] == 'active' || $this->attributes['authorize_status'] == 'active';
    }
}
