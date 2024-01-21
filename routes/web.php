<?php

use Anvts\Framework\Routing\Route;

return [
    Route::get('/', ['HomeController::class', 'index']),
];