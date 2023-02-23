<?php

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use App\Models\BaseModel;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use App\SuperAdmin\Models\PaymentTranscation;

class Company extends BaseModel
{
    use Billable, Notifiable;

    protected $table = 'companies';

    protected $dates = ['licence_expire_on'];

    protected $default = ['xid'];

    protected $guarded = ['id', 'is_global', 'subscription_plan_id', 'payment_transcation_id', 'licence_expire_on', 'package_type', 'stripe_id', 'trial_ends_at',  'created_at', 'updated_at', 'remaining_character'];

    protected $hidden = ['id', 'currency_id', 'admin_id', 'subscription_plan_id', 'payment_transcation_id', 'updated_at'];

    protected $appends = ['xid', 'x_currency_id', 'x_admin_id', 'x_subscription_plan_id', 'x_payment_transcation_id', 'login_image_url', 'light_logo_url', 'dark_logo_url', 'small_light_logo_url', 'small_dark_logo_url'];

    protected $hashableGetterFunctions = [
        'getXCurrencyIdAttribute' => 'currency_id',
        'getXAdminIdAttribute' => 'admin_id',
        'getXSubscriptionPlanIdAttribute' => 'subscription_plan_id',
        'getXPaymentTranscationIdAttribute' => 'payment_transcation_id',
    ];

    protected $casts = [
        'currency_id' => Hash::class . ':hash',
        'admin_id' => Hash::class . ':hash',
        'payment_transcation_id' => Hash::class . ':hash',
        'subscription_plan_id' => Hash::class . ':hash',
        'app_debug' => 'integer',
        'rtl' => 'integer',
        'auto_detect_timezone' => 'integer',
        'update_app_notification' => 'integer',
        'is_global' => 'integer',
        'verified' => 'integer',
    ];

    protected $filterable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('companies.is_global', 0);
        });
    }

    public function getLightLogoUrlAttribute()
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->light_logo == null ? asset('images/light.png') : Common::getFileUrl($companyLogoPath, $this->light_logo);
    }

    public function getDarkLogoUrlAttribute()
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->dark_logo == null ? asset('images/dark.png') : Common::getFileUrl($companyLogoPath, $this->dark_logo);
    }

    public function getSmallDarkLogoUrlAttribute()
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->small_dark_logo == null ? asset('images/small_dark.png') : Common::getFileUrl($companyLogoPath, $this->small_dark_logo);
    }

    public function getSmallLightLogoUrlAttribute()
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->small_light_logo == null ? asset('images/small_light.png') : Common::getFileUrl($companyLogoPath, $this->small_light_logo);
    }

    public function getLoginImageUrlAttribute()
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->login_image == null ? asset('images/login_background.svg') : Common::getFileUrl($companyLogoPath, $this->login_image);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function paymentTranscation()
    {
        return $this->belongsTo(PaymentTranscation::class);
    }

    public function admin()
    {
        return $this->belongsTo(StaffMember::class, 'admin_id', 'id');
    }
}
