<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid credentials',
            ]);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('authToken' . $user->name)->plainTextToken,
        ]);
    }

    public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();
        $request->session()->regenerate();
        Auth::logout();

        return response()->noContent();
    }
}
