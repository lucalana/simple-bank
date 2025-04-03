<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => 'You are not allowed to perform this operation.'], 403);
    }
}
