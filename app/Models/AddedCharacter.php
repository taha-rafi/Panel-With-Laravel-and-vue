<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Casts\Hash;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Models\PaymentTranscation;

class AddedCharacter extends BaseModel
{
    protected $table = 'added_characters';

    protected $default = ['xid', 'character_count'];

    protected $guarded = ['id', 'payment_transcation_id'];

    protected $hidden = ['id', 'writer_document_id'];

    protected $appends = ['xid', 'payment_transcation_id'];

    protected $filterable = ['name'];

    protected $hashableGetterFunctions = [
        'getXPaymentTranscationIdAttribute' => 'payment_transcation_id',
    ];

    protected $casts = [
        'payment_transcation_id' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function paymentTranscation()
    {
        return $this->belongsTo(PaymentTranscation::class, 'payment_transcation_id', 'id');
    }
}
