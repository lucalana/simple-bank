<?php

namespace App\Jobs;

use App\Mail\TransferCompleted;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Exception;

class EmailNotification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;
    public $backoff = [10, 20, 40, 70];

    public function __construct(
        private User $payerUser,
        private User $payeeUser,
        private float $value
    )
    {}

    public function handle(): void
    {
        $response = Http::retry(3, 1000, throw: false)->post('https://util.devi.tools/api/v1/notify');
        if ($response->getStatusCode() != 204) {
            throw new Exception();
        }
        Mail::to($this->payeeUser->email)->send(new TransferCompleted($this->payerUser->name, $this->value));
    }
}
