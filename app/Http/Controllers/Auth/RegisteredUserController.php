<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;                //  ← добавили
use Inertia\Response;               //  ← добавили

class RegisteredUserController extends Controller
{
    /**
     * Страница регистрации (Inertia).
     */
    public function create(): Response   //  ← возвращаем Response от Inertia
    {
        return Inertia::render('Auth/Register');
        // Vue-компонент лежит в  resources/js/Pages/Auth/Register.vue
    }

    /**
     * Сохранение нового пользователя.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /* ─── 1. нормализуем e-mail ───────────────────────────────────── */
        $request->merge([
            'email' => Str::lower($request->input('email')),
        ]);

        /* ─── 2. валидируем ───────────────────────────────────────────── */
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email:filter|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /* ─── 3. создаём пользователя ────────────────────────────────── */
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,       // уже в lowercase
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

