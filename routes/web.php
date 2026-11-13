<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{permalink}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/api/articles', [ArticleController::class, 'apiIndex'])->name('api.articles.index');
Route::get('/api/v1/articles', [ArticleController::class, 'apiIndex'])->name('api.v1.articles.index');
