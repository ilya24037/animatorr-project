<?php

use Illuminate\Support\Facades\Route;

// В API остаётся только то, что реально нужно мобильным/SPA.
// Регистрация перенесена в SSR (routes/web.php).
// Если когда‑нибудь понадобится REST‑регистрация —
// раскомментируйте код ниже и убедитесь, что лимитер `register` объявлен.

// Route::post('/auth/register', \App\Http\Controllers\Api\V1\Auth\RegisterController::class)
//      ->middleware(['guest', 'throttle:register'])
//      ->name('api.v1.auth.register');

Route::middleware(['throttle:api'])->group(function () {
    // … остальные API‑маршруты
});
