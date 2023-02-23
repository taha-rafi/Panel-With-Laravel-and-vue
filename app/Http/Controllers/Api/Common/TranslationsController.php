<?php

namespace App\Http\Controllers\Api\Common;

use App\Classes\LangTrans;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\Translation\IndexRequest;
use App\Http\Requests\Api\Translation\StoreRequest;
use App\Http\Requests\Api\Translation\UpdateRequest;
use App\Http\Requests\Api\Translation\DeleteRequest;
use App\Models\Translation;
use Examyou\RestAPI\ApiResponse;
use App\Http\Requests\Api\Translation\ImportRequest;
use App\Imports\TranslationImport;
use Maatwebsite\Excel\Facades\Excel;


class TranslationsController extends ApiBaseController
{
    protected $model = Translation::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function refetchTranslations()
    {
        LangTrans::seedAllModulesTranslations();

        return ApiResponse::make(
            'Success',
            []
        );
    }

    public function import(ImportRequest $request)
    {
        if ($request->hasFile('file')) {
            Excel::import(new TranslationImport, request()->file('file'));
        }

        return ApiResponse::make('Imported Successfully', []);
    }
}
