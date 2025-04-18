<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    /** @use HasFactory<\Database\Factories\WalletFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paid() : HasMany
    {
        return $this->hasMany(Transaction::class, 'payer');
    }

    public function received() : HasMany
    {
        return $this->hasMany(Transaction::class, 'payee');
    }
}
