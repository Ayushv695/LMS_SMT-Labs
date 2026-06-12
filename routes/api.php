<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[AuthController::class,'logout']);

    Route::prefix('lead')->group(function () {
        Route::get('/', [LeadController::class, 'index']);
        Route::post('store', [LeadController::class, 'store']);
        Route::get('view/{lead_id}', [LeadController::class, 'show']);
        Route::post('update/{lead_id}', [LeadController::class, 'update']);
        Route::delete('delete/{lead_id}', [LeadController::class, 'destroy']);
    });
});
