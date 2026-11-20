<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;

// Публичные маршруты
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::post('/login', [AuthController::class, 'authenticate']);

// Защищенные маршруты (требуют токен)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});