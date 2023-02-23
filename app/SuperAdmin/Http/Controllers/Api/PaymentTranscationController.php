<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Http\Requests\Api\PaymentTranscation\IndexRequest;
use App\SuperAdmin\Models\PaymentTranscation;

class PaymentTranscationController extends ApiBaseController
{
    protected $model = PaymentTranscation::class;

    protected $indexRequest = IndexRequest::class;

    public function modifyIndex($query)
    {
        $query = $query->withoutGlobalScope(CompanyScope::class)
            ->allTranscations();

        return $query;
    }
}
