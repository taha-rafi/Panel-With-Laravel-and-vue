<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Classes\Common;
use App\Casts\Hash;

class WriterCategory extends BaseModel
{
    protected $table = 'writer_categories';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'created_by', 'updated_by'];

    protected $appends = ['xid', 'x_created_by', 'x_updated_by', 'logo_url'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXCreatedByAttribute' => 'created_by',
        'getXUpdatedByAttribute' => 'updated_by',
    ];

    protected $casts = [
        'created_by' => Hash::class . ':hash',
        'updated_by' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getLogoUrlAttribute()
    {
        $categoryImagePath = Common::getFolderPath('categoryImagePath');

        return $this->logo == null ? asset('images/category.png') : Common::getFileUrl($categoryImagePath, $this->logo);
    }

    public function templates()
    {
        return $this->hasMany(WriterTemplate::class, 'writer_template_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
