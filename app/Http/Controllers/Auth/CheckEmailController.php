<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        // ✅ Заменено: убрано "dns", чтобы валидация не падала без интернета
        $request->validate([
            'email' => 'required|email',
        ]);

        // ✅ Логируем email для отладки (можно убрать в проде)
        Log::info('[CHECK-EMAIL]', ['email' => $request->email]);

        return response()->json([
            'exists' => User::where('email', $request->email)->exists(),
        ]);
    }
}
