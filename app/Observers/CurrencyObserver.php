<?php

namespace App\Observers;

use App\Models\Currency;

class CurrencyObserver
{
    public function saving(Currency $currency)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $currency->company_id = $company->id;
        }
    }
}
