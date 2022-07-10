<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;



Route::
    name('posts.')
    ->group(function (){

    Route::get('/posts', [PostController::class, 'index'])->name('index')->withoutMiddleware('auth');

    Route::get('/posts/{post}', [PostController::class, 'show'])->name('show')->whereNumber('post');

    Route::post('/posts', [PostController::class, 'store'])->name('store');

    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('update');

    Route::delete('/posts/{post}', [PostController::class, 'delete'])->name('delete');

   });

































