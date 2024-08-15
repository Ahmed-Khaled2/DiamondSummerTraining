<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::singleton('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('posts.comments', CommentController::class);

});

require __DIR__.'/auth.php';
