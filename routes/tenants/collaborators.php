<?php

use App\Http\Controllers\Tenant\CollaboratorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('collaborators', [CollaboratorController::class, 'store'])->name('collaborators.store');