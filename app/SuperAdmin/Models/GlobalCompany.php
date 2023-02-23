<?php

namespace App\SuperAdmin\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;

class GlobalCompany extends Company
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('companies.is_global', 1);
        });
    }
}
