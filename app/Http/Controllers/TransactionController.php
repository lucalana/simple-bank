<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $service
    )
    {
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate(['value' => ['required', 'numeric', 'min:1']]);
        $this->service->deposit($request->user(), $validated['value']);

        return response()->json(['success' => 'Deposit success'], 200);
    }
}
