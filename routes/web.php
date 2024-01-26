<?php

use Anvts\Framework\Http\Response;
use Anvts\Framework\Routing\Route;
use App\Controllers\HomeController;
use App\Controllers\PostController;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
    Route::get('/posts/create', [PostController::class, 'create']),
];