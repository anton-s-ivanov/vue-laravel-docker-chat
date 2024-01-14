<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Chat\ChatMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);
Route::get('/random-user-credentials', [UserController::class, 'getRandomUserCredentials']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user-profile', [UserController::class, 'getUserProfile']);
    Route::get('/user-chats', [ChatMessageController::class, 'getUserChats']);
    Route::get('/chat-messages/{chatMemberId}', [ChatMessageController::class, 'getChatMessages']);
    Route::post('/save-message', [ChatMessageController::class, 'saveMessage']);
});

