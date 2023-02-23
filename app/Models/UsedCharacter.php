<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Casts\Hash;
use App\Scopes\CompanyScope;

class UsedCharacter extends BaseModel
{
    protected $table = 'used_characters';

    protected $default = ['xid', 'character_count', 'word_count'];

    protected $guarded = ['id', 'created_by', 'writer_document_id'];

    protected $hidden = ['id', 'created_by', 'writer_document_id'];

    protected $appends = ['xid', 'x_created_by', 'x_writer_document_id'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXCreatedByIdAttribute' => 'created_by',
        'getXWriterDocumentIdAttribute' => 'writer_document_id',
    ];

    protected $casts = [
        'created_by' => Hash::class . ':hash',
        'writer_document_id' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function document()
    {
        return $this->belongsTo(WriterDocument::class, 'writer_document_id', 'id');
    }
}
