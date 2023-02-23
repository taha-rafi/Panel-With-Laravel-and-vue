<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Scopes\CompanyScope;

class Currency extends BaseModel
{
    protected $table = 'currencies';

    protected $default = ['xid', 'name', 'symbol'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];

    protected $filterable = ['name'];

    protected $casts = [
        'is_deletable' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }
}
