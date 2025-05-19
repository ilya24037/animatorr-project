<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animator;
use Inertia\Inertia;

class HomeController extends Controller
{
    /** Главная / каталог */
    public function index(Request $request)
    {
        $animators = Animator::query()
            ->when($request->filled('city'),      fn ($q) => $q->where('city', $request->city))
            ->when($request->boolean('online'),   fn ($q) => $q->where('is_online', true))
            ->when($request->filled('price_min'), fn ($q) => $q->where('price','>=', $request->price_min))
            ->when($request->filled('price_max'), fn ($q) => $q->where('price','<=', $request->price_max))
            ->orderByDesc('bumped_at')
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return Inertia::render('Home', [
            'cards'   => $animators,                                  // paginator
            'filters' => $request->only('city','online','price_min','price_max'),
            'cities'  => Animator::distinct()->pluck('city'),
        ]);
    }
}
