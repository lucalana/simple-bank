<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnauthorizedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(['error' => 'You are not allowed to perform this operation.'], 403);
    }
}
