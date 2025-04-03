<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Enums\UserType;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\UserTypeNotAllowedForTransferException;
use App\Jobs\EmailNotification;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function deposit(User $user, float $value): void
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
        });
    }

    public function transfer(User $user, float $value, int $payee)
    {
        if ($user->type === UserType::Common->value) {
            throw new UserTypeNotAllowedForTransferException();
        }
        if (($user->wallet->amount - $value) < 0) {
            throw new InsufficientBalanceException();
        }

        DB::transaction(function () use ($user, $payee, $value) {
            $payerWallet = $user->wallet;
            $payerWallet->amount = $payerWallet->amount - $value;
            $payerWallet->save();

            $payeeWallet = Wallet::find($payee);
            $payeeWallet->amount = $payeeWallet->amount + $value;
            $payeeWallet->save();

            Transaction::create([
                'payer' => $payerWallet->id,
                'payee' => $payeeWallet->id,
                'amount' => $value,
                'type' => TransactionType::Transfer->value
            ]);

            $response = Http::retry(3, 3000)->get('https://util.devi.tools/api/v2/authorize');
            if($response->getStatusCode() == 403 || $response->json()['data']['authorization'] === false) {
                throw new UnauthorizedException();
            }
        });

        $payeeUser = Wallet::find($payee)->user;
        EmailNotification::dispatch($user, $payeeUser, $value);
    }
}
