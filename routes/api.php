<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\admin\AuthController;
use App\Http\Controllers\api\admin\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Post routes
    Route::apiResource('posts', PostController::class);

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [AdminController::class, 'pendingUsers'])->middleware('admin');
        Route::post('/approve-user/{user}', [AdminController::class, 'approveUser'])->middleware('admin');
        Route::post('/reject-user/{user}', [AdminController::class, 'rejectUser'])->middleware('admin');
        Route::get('/all-posts', [AdminController::class, 'allPosts'])->middleware('admin');
    });
});
