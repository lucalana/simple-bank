<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'Unable to process the transfer. Your account has insufficient funds.'], 422);
    }
}
