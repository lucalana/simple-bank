<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $service
    )
    {
    }

    public function deposit(Request $request) : JsonResponse
    {
        $validated = $request->validate(['value' => ['required', 'numeric', 'min:1']]);
        $this->service->deposit($request->user(), $validated['value']);

        return response()->json(['success' => 'Deposit success'], 200);
    }

    public function transfer(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'value' => ['required', 'numeric', 'min:1'],
            'payee' => ['required', 'exists:wallets,id'],
        ]);
        $this->service->transfer($request->user(), ...$validated);

        return response()->json(['success' => 'Transfer success'], 200);
    }
}
