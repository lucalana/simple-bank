<?php

namespace App\Jobs;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateWalletBalance implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Transaction $transaction,
    ) {}

    public function handle(): void
    {
        $walletPayee = $this->transaction->payeeWallet;
        $amount = $this->transaction->amount;

        if(TransactionType::Transfer->value == $this->transaction->type){
            $walletPayer = $this->transaction->payerWallet;
            $walletPayer->amount -= $amount;
            $walletPayer->save();
        }
        $walletPayee->amount += $amount;
        $walletPayee->save();
    }
}
