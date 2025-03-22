<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    
Route::prefix('auth')->middleware('api')->group(function () {
    // Registration route
    Route::post('register', RegisterController::class);

    // Login route
    Route::post('login', LoginController::class);

    // Logout route
    // Route::post('logout', LogoutController::class);

    // User details route (authenticated users only)
    Route::get('user', ProfileController::class)->middleware('auth:api');
    Route::post('logout', LogoutController::class)->middleware('auth:api');
});


Route::apiResource('tiles', TilesController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('colors', ColorController::class);
