<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::put('/profile/{id}', [ProfileController::class, 'update']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy']);



    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::delete('/favorites/{movie_id}', [FavoriteController::class, 'destroy']);
});

// routes/api.php
// Route::middleware('auth:api')->group(function () {
//     Route::post('/profile', [ProfileController::class, 'store']);
//     Route::put('/profile/{id}', [ProfileController::class, 'update']);
//     Route::get('/profile', [ProfileController::class, 'show']);
//     Route::delete('/profile/{id}', [ProfileController::class, 'destroy']);
// });
