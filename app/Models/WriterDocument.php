<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Casts\Hash;
use App\Scopes\CompanyScope;

class WriterDocument extends BaseModel
{
    protected $table = 'writer_documents';

    protected $default = ['xid', 'title'];

    protected $guarded = ['id', 'prompt_text', 'word_count', 'character_count', 'created_by', 'writer_template_id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'created_by', 'writer_template_id', 'workspace_id'];

    protected $appends = ['xid', 'x_created_by', 'x_writer_template_id', 'x_workspace_id'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXCreatedByAttribute' => 'created_by',
        'getXWriterTemplateIdAttribute' => 'writer_template_id',
        'getXWorkspaceIdAttribute' => 'workspace_id',
    ];

    protected $casts = [
        'created_by' => Hash::class . ':hash',
        'writer_template_id' => Hash::class . ':hash',
        'workspace_id' => Hash::class . ':hash',
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

    public function workspace()
    {
        return $this->belongsTo(WorkSpace::class, 'workspace_id', 'id');
    }

    public function writerTemplate()
    {
        return $this->belongsTo(WriterTemplate::class, 'writer_template_id', 'id');
    }
}
