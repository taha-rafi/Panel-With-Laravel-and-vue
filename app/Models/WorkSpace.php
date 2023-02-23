<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Casts\Hash;
use App\Scopes\CompanyScope;

class WorkSpace extends BaseModel
{
    protected $table = 'workspaces';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'created_by'];

    protected $hidden = ['id', 'created_by'];

    protected $appends = ['xid', 'x_created_by'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXCreatedByIdAttribute' => 'created_by',
    ];

    protected $casts = [
        'created_by' => Hash::class . ':hash',
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
}
