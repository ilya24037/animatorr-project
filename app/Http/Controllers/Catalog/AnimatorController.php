<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Animator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnimatorController extends Controller
{
    /** Список / главная */
    public function index(Request $request)
    {
        $animators = Animator::query()
            ->when($request->filled('city'),      fn ($q) => $q->where('city',  $request->city))
            ->when($request->boolean('online'),   fn ($q) => $q->where('is_online', true))
            ->when($request->filled('price_min'), fn ($q) => $q->where('price','>=', $request->price_min))
            ->when($request->filled('price_max'), fn ($q) => $q->where('price','<=', $request->price_max))
            ->orderByDesc('bumped_at')
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return Inertia::render('Catalog/Index', [
            'animators' => $animators,
            'filters'   => $request->only('city','online','price_min','price_max'),
        ]);
    }

    /** Карточка аниматора */
    public function show(Animator $animator)
    {
        return Inertia::render('Catalog/Show', compact('animator'));
    }
}
