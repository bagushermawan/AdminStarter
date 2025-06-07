<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/check-username', function (\Illuminate\Http\Request $request) {
    $base = preg_replace('/\s+/', '', strtolower($request->input('username')));
    $available = !\App\Models\User::where('username', $base)->exists();

    if ($available) {
        return response()->json(['available' => true]);
    }

    // Generate 3 saran alternatif
    $suggestions = [];
    for ($i = 0; $i < 2; $i++) {
        $suggest = $base . random_int(10, 99);
        while (\App\Models\User::where('username', $suggest)->exists()) {
            $suggest = $base . random_int(10, 99);
        }
        $suggestions[] = $suggest;
    }

    return response()->json([
        'available' => false,
        'suggestions' => $suggestions,
    ]);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
