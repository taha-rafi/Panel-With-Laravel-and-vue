<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\WriterCategory\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\WriterCategory\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\WriterCategory\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\WriterCategory\DeleteRequest;
use App\Models\WriterCategory;

class WriterCategoryController extends ApiBaseController
{

    protected $model = WriterCategory::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function storing($writerCategory)
    {
        $loggedUser = user();

        $writerCategory->created_by = $loggedUser->id;

        return $writerCategory;
    }

    public function updating($writerCategory)
    {
        $loggedUser = user();

        $writerCategory->updated_by = $loggedUser->id;

        return $writerCategory;
    }
}
