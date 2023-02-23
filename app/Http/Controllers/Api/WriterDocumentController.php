<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\WriterDocument\IndexRequest;
use App\Http\Requests\Api\WriterDocument\UpdateRequest;
use App\Models\WriterDocument;
use Illuminate\Support\Str;

class WriterDocumentController extends ApiBaseController
{

    protected $model = WriterDocument::class;

    protected $indexRequest = IndexRequest::class;
    protected $updateRequest = UpdateRequest::class;

    public function updating($writerDocument)
    {
        $request = request();

        $writerDocument->character_count = Str::length($request->content);
        $writerDocument->word_count = Str::wordCount($request->content);

        if ($request->has('workspace_id') && $request->workspace_id != "") {
            $writerDocument->workspace_id = $this->getIdFromHash($request->workspace_id);
        }

        return $writerDocument;
    }
}
