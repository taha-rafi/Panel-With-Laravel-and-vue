<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function saving(Role $role)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $role->company_id = company()->id;
        }
    }
}
