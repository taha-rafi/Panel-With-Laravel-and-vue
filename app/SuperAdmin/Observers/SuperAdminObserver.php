<?php

namespace App\SuperAdmin\Observers;

use App\SuperAdmin\Models\SuperAdmin;

class SuperAdminObserver
{
    public function saved(SuperAdmin $superadmin)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $superadmin->company_id = company()->id;
        }
    }
}
