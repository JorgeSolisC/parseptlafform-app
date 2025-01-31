<?php
use App\Http\Controllers\System\Tenant\TenantController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('tenants', [TenantController::class, 'store'])->name('tenants.store');