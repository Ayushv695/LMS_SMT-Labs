<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\FrontendLeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('guest')->group(function(){

    Route::get('register', [FrontendAuthController::class, 'showRegister'])->name('frontend-register');
    Route::post('register', [FrontendAuthController::class, 'register'])
        ->name('frontend-registration');

    Route::get('/', [FrontendAuthController::class, 'showLogin'])->name('frontend-login');
    Route::post('authenticate', [FrontendAuthController::class, 'login'])
        ->name('frontend-authenticate');
});

Route::middleware('auth')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('lead', [FrontendLeadController::class, 'index'])->name('leads-list');
    Route::post('logout', [FrontendAuthController::class, 'logout'])
        ->name('frontend-logout');
});
