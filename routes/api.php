<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\StrategyController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/me/profile', [UserController::class, 'updateProfile']);
    
    Route::post('/strategies', [StrategyController::class, 'store']);
    Route::put('/strategies/{strategy}', [StrategyController::class, 'update']);
    Route::delete('/strategies/{strategy}', [StrategyController::class, 'destroy']);

    Route::post('/strategies/{strategy}/vote', [VoteController::class, 'store']);
    Route::get('/my-strategies', [StrategyController::class, 'fetchByUserId']);
    Route::delete('/strategies/{strategy}/vote', [VoteController::class, 'destroy']);

    Route::post('/strategies/{strategy}/media', [MediaController::class, 'store']);
    Route::delete('/media/{id}', [MediaController::class, 'destroy']);
});


// ✅ Route publique 
Route::get('/strategies', [StrategyController::class, 'index']);
Route::get('/strategies/{strategy}', [StrategyController::class, 'show']);
