<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an incoming login request.
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Неверный e‑mail или пароль.'],
            ]);
        }

        /** @var \App\Models\User $user */
        $user  = $request->user();
        $token = $user->createToken('spa')->plainTextToken;

        return response()->json([
            'data' => [
                'user'  => $user,
                'token' => $token,
            ],
        ]);
    }
}
