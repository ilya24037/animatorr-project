<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes - v1
|--------------------------------------------------------------------------
|
| Здесь находятся маршруты публичного API первой версии.
| Они все префиксируются `/api/v1` через RouteServiceProvider или в файле web server.
|
*/

Route::prefix('v1')
    ->middleware(['guest', 'throttle:5,1'])
    ->group(function () {
        Route::post('/auth/register', RegisterController::class)
             ->name('api.v1.auth.register');
    });
