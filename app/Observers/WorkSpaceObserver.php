<?php

namespace App\Observers;

use App\Models\WorkSpace;

class WorkSpaceObserver
{
    public function saving(WorkSpace $workSpace)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $workSpace->company_id = company()->id;
        }
    }
}
