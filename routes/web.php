<?php

use Anvts\Framework\Routing\Route;
use App\Controllers\HomeController;

return [
    Route::get('/', [HomeController::class, 'index']),
];