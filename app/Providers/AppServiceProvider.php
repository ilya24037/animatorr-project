<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\DB;      // ① добавили
use Illuminate\Support\Facades\Log;     // ② добавили
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ⚡️ Vite
        Vite::prefetch(concurrency: 3);

        // ⚡️ Логируем каждый SQL-запрос
        DB::listen(function ($query) {
            Log::debug('SQL', [
                'sql'      => $query->sql,
                'bindings' => $query->bindings,
                'time_ms'  => $query->time,
            ]);
        });
    }
}
