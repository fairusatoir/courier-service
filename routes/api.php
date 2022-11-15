<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CallbackController;
use App\Http\Controllers\API\CourierOrderController;
use App\Http\Controllers\API\OrderCourierTypeController;
use App\Http\Controllers\API\VendorController;
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
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});



/** Courier Main Service Route */
Route::prefix('courier')->group(function () {

    Route::get('/welcome', function () {
        return "<h1>Welcome to API courier service</h1>";
    });

    Route::group(['prefix' => '1.0', 'middleware' => ['validRequest','AuthAccessToken']], function(){

        Route::get('/welcome', function () {
            return "<h1>Welcome to API courier service v1.0</h1>";
        });

        Route::post('/orders/data', [CourierOrderController::class, 'index']);
        Route::post('/orders/courier', [CourierOrderController::class, 'store']);
        Route::post('/calculate-order', [CourierOrderController::class, 'calculatePrice']);

        Route::prefix('vendors')->group(function () {
            Route::get('/', [VendorController::class, 'index']);
            Route::get('/{id}', [VendorController::class, 'show']);
        });
        
        Route::prefix('order/type')->group(function () {
            Route::get('/', [OrderCourierTypeController::class, 'index']);
        });
    });


    Route::prefix('callback')->group(function () {
        Route::prefix('1.0')->group(function () {
            Route::post('/borzo', [CallbackController::class, 'BorzoCallback']);
        });
    });
});
