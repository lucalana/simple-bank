<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTypeNotAllowedForTransferException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(['error' => 'Transfer failed: Your account is not eligible for this action.'], 422);
    }
}
