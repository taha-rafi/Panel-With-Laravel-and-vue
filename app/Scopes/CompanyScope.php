<?php

namespace App\Scopes;

use App\Classes\Common;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        // When user is logged in
        // auth('api')->user() do not work in apply so we have use auth()->check()
        if (app_type() == 'saas' && auth('api')->check() && Schema::hasColumn($model->getTable(), 'company_id')) {
            $company = company();

            // company scope will not be applied to global company(superadmin company)
            if ($company && !$company->is_global) {
                $builder->where($model->getTable() . '.company_id', '=', Common::getIdFromHash($company->xid));
            }
        } else if (app_type() == 'non-saas' && auth('api')->check() && Schema::hasColumn($model->getTable(), 'company_id')) {
            $company = company();

            $builder->where($model->getTable() . '.company_id', '=', Common::getIdFromHash($company->xid));
        }
    }
}
