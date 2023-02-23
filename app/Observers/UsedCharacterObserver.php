<?php

namespace App\Observers;

use App\Models\UsedCharacter;

class UsedCharacterObserver
{
    public function saving(UsedCharacter $usedCharacter)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $usedCharacter->company_id = company()->id;
        }
    }
}
