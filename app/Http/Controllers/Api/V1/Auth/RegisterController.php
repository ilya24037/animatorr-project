<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Handle the incoming registration request.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->string('name'),
            'email'    => $request->string('email'),
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        // Выдаём SPA‑токен (Laravel Sanctum)
        $token = method_exists($user, 'createToken')
            ? $user->createToken('spa')->plainTextToken
            : null;

        return response()->json([
            'data'  => ['user' => $user],
            'token' => $token,
        ], 201);
    }
}
