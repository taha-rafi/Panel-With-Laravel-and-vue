<?php

namespace App\SuperAdmin\Models;

use App\Models\BaseModel;

class OfflinePaymentMode extends BaseModel
{
    protected $table = 'offline_payment_modes';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $filterable = ['name'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];

    protected static function boot()
    {
        parent::boot();
    }
}
