<?php

namespace App\Observers;

use App\Models\WriterDocument;

class WriterDocumentObserver
{
    public function saving(WriterDocument $writerDocument)
    {
        $company = company();

        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if ($company && !$company->is_global) {
            $writerDocument->company_id = company()->id;
        }
    }
}
