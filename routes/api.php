<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user',function (Request $request) { return $request->user(); });
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/me/profile', [UserController::class, 'updateProfile']);
    
    Route::apiResource('strategies', StrategyController::class);
    Route::post('/strategies/{strategy}/vote', [VoteController::class, 'store']);
    Route::delete('/strategies/{strategy}/vote', [VoteController::class, 'destroy']);

    Route::post('/strategies/{strategy}/media', [MediaController::class, 'store']);
    Route::delete('/media/{id}', [MediaController::class, 'destroy']);
});