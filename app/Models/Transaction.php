<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'payer',
        'payee',
        'type',
        'amount',
    ];

    public function casts(): array
    {
        return [
            'type' => TransactionType::class,
        ];
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee');
    }
}
