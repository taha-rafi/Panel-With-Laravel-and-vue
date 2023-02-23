<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Scopes\CompanyScope;
use App\Casts\Hash;
use App\Classes\Common;

class WriterTemplate extends BaseModel
{
    protected $table = 'writer_templates';

    protected $default = ['xid', 'name', 'symbol'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'created_by', 'updated_by', 'writer_category_id'];

    protected $appends = ['xid', 'x_created_by', 'x_updated_by', 'logo_url', 'x_writer_category_id'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXWriterCategoryIdAttribute' => 'writer_category_id',
        'getXCreatedByAttribute' => 'created_by',
        'getXUpdatedByAttribute' => 'updated_by',
    ];

    protected $casts = [
        'writer_category_id' => Hash::class . ':hash',
        'created_by' => Hash::class . ':hash',
        'updated_by' => Hash::class . ':hash',
        'form_fields' => 'array',
        'status' => 'integer',
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function getLogoUrlAttribute()
    {
        $logoImagePath = Common::getFolderPath('templateImagePath');

        return $this->logo == null ? asset('images/template.png') : Common::getFileUrl($logoImagePath, $this->logo);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function category()
    {
        return $this->belongsTo(WriterCategory::class, 'writer_category_id', 'id');
    }
}
