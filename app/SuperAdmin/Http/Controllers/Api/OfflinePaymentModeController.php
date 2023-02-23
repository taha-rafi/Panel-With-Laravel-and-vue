<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\OfflinePaymentMode\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\OfflinePaymentMode\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\OfflinePaymentMode\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\OfflinePaymentMode\DeleteRequest;
use App\SuperAdmin\Models\OfflinePaymentMode;

class OfflinePaymentModeController extends ApiBaseController
{
    protected $model = OfflinePaymentMode::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;
}
