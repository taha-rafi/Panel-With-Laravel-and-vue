<?php

namespace App\SuperAdmin\Models;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Builder;

class GlobalSettings extends Settings
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('global', function (Builder $builder) {
            $builder->where('settings.is_global', 1);
        });

        static::saving(function ($model) {
            $model->is_global = 1;
        });
    }
}
