<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Sanctum token
        $token = $user->createToken('spa')->plainTextToken;

        return response()->json([
            'data' => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 201);
    }
}
