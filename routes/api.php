<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;


Route::get('profiles/{user_id}', [ProfileController::class, 'show']);
Route::get('tags', [TagController::class, 'list']);

Route::prefix('users')->group(function () {
    Route::post('store', [UserController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);
});

Route::prefix('articles')->group(function () {
    Route::get('feed', [ArticleController::class, 'feed']);
    Route::get('{article_id}', [ArticleController::class, 'show']);
    Route::get('{article_id}/comments', [CommentController::class, 'list']);
});

Route::middleware('auth')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'show']);
        Route::put('{user_id}', [UserController::class, 'update']);
    });

    Route::prefix('profiles')->group(function () {
        Route::post('{user_id}/follow', [ProfileController::class, 'follow']);
        Route::delete('{user_id}/follow', [ProfileController::class, 'unfollow']);
    });

    Route::prefix('articles')->group(function () {
        Route::post('store', [ArticleController::class, 'store']);
        Route::put('{article_id}', [ArticleController::class, 'update']);
        Route::delete('{article_id}', [ArticleController::class, 'destroy']);

        Route::post('{article_id}/favorite', [ArticleController::class, 'favorite']);
        Route::delete('{article_id}/favorite', [ArticleController::class, 'unfavorite']);

        Route::post('{article_id}/comments', [CommentController::class, 'store']);
        Route::delete('{article_id}/comments/{comment_id}', [CommentController::class, 'destroy']);
    });
});
