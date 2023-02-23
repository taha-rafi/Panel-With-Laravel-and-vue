<?php

namespace App\Observers;

use App\Models\Settings;

class SettingObserver
{
    public function saving(Settings $settings)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $settings->company_id = company()->id;
        }
    }
}
