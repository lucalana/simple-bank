<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserTypeNotAllowedForTransferException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'Transfer failed: Your account is not eligible for this action.'], 422);
    }
}
