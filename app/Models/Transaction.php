<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer',
        'payee',
        'type',
        'amount',
    ];

    public function payerWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer');
    }

    public function payeeWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee');
    }
}
