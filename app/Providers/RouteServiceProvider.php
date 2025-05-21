<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        // login attempts: 5 per 30 seconds by IP+email
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email.$request->ip())->decaySeconds(30);
        });

        // register attempts: 3 per minute by IP
        RateLimiter::for('register', fn(Request $r) => Limit::perMinute(3)->by($r->ip()));

        // default api: 120 per minute
        RateLimiter::for('api', fn(Request $r) => Limit::perMinute(120)->by($r->ip()));

        $this->routes(function () {
            Route::middleware(['api', 'throttle:api'])
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
