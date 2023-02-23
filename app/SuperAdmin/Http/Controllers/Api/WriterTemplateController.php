<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\WriterTemplate\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\WriterTemplate\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\WriterTemplate\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\WriterTemplate\DeleteRequest;
use App\Models\WriterTemplate;

class WriterTemplateController extends ApiBaseController
{

    protected $model = WriterTemplate::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function storing($writerTemplate)
    {
        $loggedUser = user();

        $writerTemplate->created_by = $loggedUser->id;

        return $writerTemplate;
    }

    public function updating($writerTemplate)
    {
        $loggedUser = user();

        $writerTemplate->updated_by = $loggedUser->id;

        return $writerTemplate;
    }
}
