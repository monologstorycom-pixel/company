<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Chatbot\Controllers\ChatbotController;

// Chatbot API routes
Route::get('/chatbot', [ChatbotController::class, 'handleGet']); // Handle accidental GET requests
Route::post('/chatbot', [ChatbotController::class, 'handleMessage']);