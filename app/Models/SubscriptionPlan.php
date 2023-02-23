<?php

namespace App\Models;

use App\Models\BaseModel;

class SubscriptionPlan extends BaseModel
{
    protected $table = 'subscription_plans';

    protected $default = ['id', 'xid', 'name', 'description', 'modules'];

    protected $guarded = ['id', 'created_at', 'updated_at', 'default'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];

    protected $filterable = ['id', 'name'];

    protected $hashableGetterFunctions = [];

    protected $casts = [
        'modules' => 'array',
        'features' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    // protected $appends = [
    //     'formatted_annual_price',
    //     'formatted_monthly_price'
    // ];

    // public function companies()
    // {
    //     return $this->hasMany(Company::class);
    // }

    // public function formatSizeUnits($bytes)
    // {
    //     if ($bytes >= 1024) {
    //         $bytes = number_format($bytes / 1024, 2) . ' GB';
    //     } elseif ($bytes > 1) {
    //         $bytes = $bytes . ' MB';
    //     } else {
    //         $bytes = '0 MB';
    //     }

    //     return $bytes;
    // }

    // function getFormattedAnnualPriceAttribute()
    // {
    //     $global = global_settings();
    //     $globalCurrency = $global->currency;

    //     $symbol = $globalCurrency->symbol;
    //     $amount = $this->annual_price;
    //     $position = $globalCurrency->position;

    //     return ($position == 'front') ? ($symbol . $amount) : ($amount . $symbol);
    // }

    // function getFormattedMonthlyPriceAttribute()
    // {
    //     $global = global_settings();
    //     $globalCurrency = $global->currency;

    //     $symbol = $globalCurrency->symbol;
    //     $amount = $this->monthly_price;
    //     $position = $globalCurrency->position;

    //     return ($position == 'front') ? ($symbol . $amount) : ($amount . $symbol);
    // }
}
