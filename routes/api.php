<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| assigned the "api" middleware group. They are typically stateless.
|
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// Define your routes
Route::post('/interview', [InterviewController::class, 'post']);
Route::get('/interview', [InterviewController::class, 'get']);
