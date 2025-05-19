<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Импорт контроллеров
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Catalog\HomeController;
use App\Http\Controllers\Catalog\AnimatorController;
use App\Http\Controllers\Cabinet\AdController;

use App\Http\Controllers\Auth\{
    CheckEmailController,
    RegisteredUserController,
    AuthenticatedSessionController,
    PasswordResetLinkController,
    NewPasswordController,
    VerifyEmailController,
    EmailVerificationNotificationController
};

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Каталог
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/animator/{animator}-{slug}', [AnimatorController::class, 'show'])
      ->whereNumber('animator')
      ->name('animator.show');

/*
|--------------------------------------------------------------------------
| Auth (гость)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    // главный POST-роут
    Route::post('/check-email', CheckEmailController::class)
          ->name('check-email');

    // алиас-ловушка на GET (favicon_prefetch, случайный GET) ⇒ 405-JSON
    Route::get('/check-email', fn () =>
        response()->json(['message' => 'Method Not Allowed'], 405)
    );

    Route::get ('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get ('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
          ->middleware('throttle:6,1');

    Route::get ('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
          ->name('password.email')
          ->middleware('throttle:6,1');

    Route::get ('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',         [NewPasswordController::class, 'store'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Подтверждение почты
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','signed'])->get('/verify-email/{id}/{hash}', VerifyEmailController::class)
      ->name('auth.verification.verify');

Route::post('/email/verification-notification',
            [EmailVerificationNotificationController::class, 'store'])
      ->middleware(['auth','throttle:verification'])
      ->name('auth.verification.send');

/*
|--------------------------------------------------------------------------
| Авторизованные маршруты
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
          ->middleware('verified')
          ->name('dashboard');

    Route::prefix('cabinet')->name('cabinet.')->group(function () {
        Route::resource('ads', AdController::class)->except(['index','show']);
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get   ('/', [ProfileController::class, 'edit'])   ->name('edit');
        Route::patch ('/', [ProfileController::class, 'update']) ->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
          ->name('auth.logout');
});

/*
|--------------------------------------------------------------------------
| Фолбек 404
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => Inertia::render('Errors/404'))->name('fallback');
