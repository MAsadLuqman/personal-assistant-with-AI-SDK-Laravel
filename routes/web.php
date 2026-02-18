<?php

use App\Http\Controllers\AssistantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', [AssistantController::class, 'chat']);
Route::get('/voice', [AssistantController::class, 'voice']);

Route::post('/assistant/chat', [AssistantController::class, 'sendMessage']);
Route::post('/assistant/stream', [AssistantController::class, 'streamMessage']);
Route::post('/assistant/transcribe', [AssistantController::class, 'transcribe']);
Route::post('/assistant/speak', [AssistantController::class, 'speak']);
