<?php

use App\Http\Controllers\ParseWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', fn() => view('vue'));

