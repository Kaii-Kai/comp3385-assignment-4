<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/api/v1/movies', [MovieController::class, 'index'])->middlware('auth:api');

Route::post('/api/v1/movies', [MovieController::class, 'store'])->middlware('auth:api');

Route::post('/v1/login', [AuthController::class, 'login']);

Route::post('/v1/logout', [AuthController::class, 'logout']);