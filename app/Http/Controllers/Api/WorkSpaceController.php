<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\WorkSpace\IndexRequest;
use App\Http\Requests\Api\WorkSpace\StoreRequest;
use App\Http\Requests\Api\WorkSpace\UpdateRequest;
use App\Http\Requests\Api\WorkSpace\DeleteRequest;
use App\Models\WorkSpace;

class WorkSpaceController extends ApiBaseController
{

    protected $model = WorkSpace::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function storing($workspace)
    {
        $loggedUser = user();

        $workspace->created_by = $loggedUser->id;

        return $workspace;
    }
}
