<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $service
    )
    {
    }

    public function deposit(DepositRequest $request) : JsonResponse
    {
        $this->service->deposit($request->user(), ...$request->validated());

        return response()->json(['success' => 'Deposit success'], 200);
    }

    public function transfer(TransferRequest $request) : JsonResponse
    {
        $this->service->transfer($request->user(), ...$request->validated());

        return response()->json(['success' => 'Transfer success'], 200);
    }
}
