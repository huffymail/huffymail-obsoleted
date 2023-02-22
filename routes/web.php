<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('/inbox/{to}', [\App\Http\Controllers\InboxController::class, 'show']);

Route::get('/inbox/{to}/messages/{message_id}', [\App\Http\Controllers\InboxMessageController::class, 'show']);
