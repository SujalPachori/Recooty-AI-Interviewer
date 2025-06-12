<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InterviewController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/hello', function (Request $request) {
    return response()->json([
        'success' => true,
        'data' => 'THANK YOU!'
    ], 200);
});





require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
