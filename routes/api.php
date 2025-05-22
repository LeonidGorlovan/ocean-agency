<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('me');

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post}', [PostController::class, 'view']);
        Route::post('/{post}/comments', [PostController::class, 'createComment']);
    });
});


