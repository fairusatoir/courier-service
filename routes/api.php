<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CallbackController;
use App\Http\Controllers\API\CourierOrderController;
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

/** User Management Route */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});

/** Courier Main Service Route */
Route::group(['middleware' => ['auth:sanctum','validRequest']], function () {
    Route::prefix('courier')->group(function () {
        Route::prefix('1.0')->group(function () {
            
            Route::get('/welcome', function () {
                return "<h1>Welcome to API courier service</h1>";
            });

            Route::post('/orders', [CourierOrderController::class, 'index']);

            Route::post('/calculate-order', [CourierOrderController::class, 'calculatePrice']);
        
        });


        Route::prefix('borzo')->group(function () {
            Route::prefix('1.0')->group(function () {

                Route::post('/callback', [CallbackController::class, 'BorzoCallback']);
            });
        });
    });
});
