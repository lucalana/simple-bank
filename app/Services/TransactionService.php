<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function deposit($user, $value): void
    {
        DB::transaction(function () use ($user, $value) {
            $wallet = $user->wallet;
            $wallet->amount = $wallet->amount + $value;
            $wallet->save();

            Transaction::create([
                'payee' => $wallet->id,
                'amount' => $value,
                'type' => TransactionType::Deposit->value
            ]);
        }, 3);
    }
}
