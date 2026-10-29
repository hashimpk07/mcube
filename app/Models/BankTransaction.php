<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankTransaction extends Model
{
    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'amount',
        'status',
        'reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(
            BankAccount::class,
            'from_account_id'
        );
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(
            BankAccount::class,
            'to_account_id'
        );
    }
}