<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;

Route::prefix('v1')->group(function () {

    // Registration – limited 3 req/min per IP
    Route::post('/auth/register', RegisterController::class)
         ->middleware(['guest', 'throttle:register'])
         ->name('api.v1.auth.register');

    // Login – limited 5 attempts / 30 sec per IP+email
    Route::post('/auth/login', LoginController::class)
         ->middleware(['guest', 'throttle:login'])
         ->name('api.v1.auth.login');
});
