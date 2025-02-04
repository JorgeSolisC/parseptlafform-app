<?php

use App\Http\Controllers\ParseWebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/users', [UserController::class, 'store']);
Route::post('/mongo-users', [UserController::class, 'storeMongo']);

Route::post('/webhook/parse', [ParseWebhookController::class, 'handleWebhook']);
