<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Show the form for creating a new ad.
     */
    public function create()
    {
        return inertia('Cabinet/Ads/Create');
    }

    /**
     * Store a newly created ad in storage.
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        // Сохранение объявления
        auth()->user()->ads()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Объявление создано');
    }

    /**
     * Show the form for editing the specified ad.
     */
    public function edit($id)
    {
        $ad = auth()->user()->ads()->findOrFail($id);

        return inertia('Cabinet/Ads/Edit', [
            'ad' => $ad
        ]);
    }

    /**
     * Update the specified ad in storage.
     */
    public function update(Request $request, $id)
    {
        $ad = auth()->user()->ads()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $ad->update($validated);

        return redirect()->route('dashboard')->with('success', 'Объявление обновлено');
    }

    /**
     * Remove the specified ad from storage.
     */
    public function destroy($id)
    {
        $ad = auth()->user()->ads()->findOrFail($id);
        $ad->delete();

        return redirect()->route('dashboard')->with('success', 'Объявление удалено');
    }
}
