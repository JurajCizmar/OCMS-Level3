<?php

use AppUser\User\Http\Controllers\UserController;
use AppUser\User\Http\Middleware\UserMiddleware;

Route::group([
    'prefix' => 'user'
], function () {
    Route::post('/register', [UserController::class, 'registerNewUser']);

    Route::post('/login', [UserController::class, 'login']);

    Route::post('/logout', [UserController::class, 'logout'])
        ->middleware(UserMiddleware::class);

    // Route::delete('/delete', [UserController::class, 'deleteUsers'])
    //     ->middleware(UserMiddleware::class);
});