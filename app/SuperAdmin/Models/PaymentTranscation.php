<?php

namespace App\SuperAdmin\Models;

use App\Classes\Common;
use App\Models\BaseModel;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Scopes\CompanyScope;

class PaymentTranscation extends BaseModel
{
    protected $table = 'payment_transcations';

    protected $dates = ['paid_on', 'next_payment_date'];

    protected $hidden = ['id', 'company_id', 'subscription_plan_id', 'offline_payment_mode_id', 'submitted_by_id'];

    protected $appends = ['xid', 'x_company_id', 'x_subscription_plan_id', 'x_offline_payment_mode_id', 'x_submitted_by_id', 'proof_document_url'];

    protected $hashableGetterFunctions = [
        'getXCompanyIdAttribute' => 'company_id',
        'getXSubscriptionPlanIdAttribute' => 'subscription_plan_id',
        'getXOfflinePaymentModeIdAttribute' => 'offline_payment_mode_id',
        'getXSubmittedByIdAttribute' => 'submitted_by_id',
    ];

    protected $casts = [
        'response_data' => 'array',
        'is_offline_request' => 'integer',
    ];

    protected $filterable = ['status', 'company_id', 'subscription_plan_id', 'offline_payment_mode_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function getProofDocumentUrlAttribute()
    {
        $offlineRequestDocumentPath = Common::getFolderPath('offlineRequestDocumentPath');

        return $this->proof_document == null ? null : Common::getFileUrl($offlineRequestDocumentPath, $this->proof_document);
    }

    public function scopePaypal($query)
    {
        return $query->where('payment_method', 'paypal');
    }

    public function scopeStripe($query)
    {
        return $query->where('payment_method', 'stripe');
    }

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

    public function scopeOfflineRequests($query)
    {
        return $query->where('payment_method', 'offline')
            ->where('is_offline_request', 1);
    }

    // All completed transcations
    // From online or approved offline requests
    public function scopeAllTranscations($query)
    {
        return $query->where(function ($query) {
            $query->where('payment_method', '!=', 'offline');
        })
            ->orWhere(function ($query) {
                $query->where('payment_method', 'offline')
                    ->where('status', 'approved');
            });
    }

    public function scopeOnline($query)
    {
        return $query->where('payment_method', '!=', 'offline');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function offlinePaymentMode()
    {
        return $this->belongsTo(OfflinePaymentMode::class);
    }

    public function submittor()
    {
        return $this->belongsTo(User::class, 'submitted_by_id', 'id');
    }
}
