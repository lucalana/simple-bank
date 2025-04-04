<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Enums\UserType;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\UserTypeNotAllowedForTransferException;
use App\Jobs\EmailNotification;
use App\Jobs\UpdateWalletBalance;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function deposit(User $user, float $value): void
    {
        $transaction = DB::transaction(function () use ($user, $value) {
            return Transaction::create([
                'payee' => $user->wallet->id,
                'amount' => $value,
                'type' => TransactionType::Deposit->value
            ]);
        });
        UpdateWalletBalance::dispatch($transaction);
    }

    public function transfer(User $user, float $value, int $payee)
    {
        if ($user->type === UserType::Common->value) {
            throw new UserTypeNotAllowedForTransferException();
        }
        if (($user->wallet->amount - $value) < 0) {
            throw new InsufficientBalanceException();
        }

        $transaction = DB::transaction(function () use ($user, $payee, $value) {
            $response = Http::get('https://util.devi.tools/api/v2/authorize');
            if($response->getStatusCode() == 403 || $response->json()['data']['authorization'] === false) {
                throw new UnauthorizedException();
            }

            return Transaction::create([
                'payer' => $user->wallet->id,
                'payee' => Wallet::find($payee)->id,
                'amount' => $value,
                'type' => TransactionType::Transfer->value
            ]);
        });

        UpdateWalletBalance::withChain([
            new  EmailNotification($user->name, Wallet::find($payee)->user->email, $value),
        ])->dispatch($transaction);
    }
}
