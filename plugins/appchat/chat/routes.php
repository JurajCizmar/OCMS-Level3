<?php

use AppUser\User\Http\Controllers\UserController;
use AppChat\Chat\Http\Controllers\ChatController;
use AppUser\User\Http\Middleware\UserMiddleware;

Route::group([
    'prefix' => 'chat',
    'middleware' => UserMiddleware::class
], function () {

    Route::get('/users', [ChatController::class, 'getUsersIds']);

    Route::post('/create', [ChatController::class, 'createNewChat']);

    Route::delete('/delete', [ChatController::class, 'deleteEveryChat']);

    Route::get('/show-chats', [ChatController::class, 'showUserTheirChats']);

    Route::post('/name-chat', [ChatController::class, 'nameChat']);

    Route::post('/chat', [ChatController::class, 'writeMessageToChat']);

    Route::get('/see-chat', [ChatController::class, 'showMyChat']);

    Route::get('/show-emojis', [ChatController::class, 'showEmojis']);

    Route::post('/react', [ChatController::class, 'reactToMessage']);

    Route::post('/reply', [ChatController::class, 'replyToMessage']);

    Route::post('/send-attachment', [ChatController::class, 'sendAttachment']);

    // Route::post('/test', [ChatController::class, 'test']);
});