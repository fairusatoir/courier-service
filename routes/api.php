<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test',[CourierOrderController::class, 'index']);


Route::prefix('1.0')->group(function () {
    Route::get('/', function () {
        return "<h1>Welcome to API courier service</h1>";
    });


    Route::post('/orders',[CourierOrderController::class, 'index']);
    Route::post('/calculate-order',[CourierOrderController::class, 'calculatePrice']);

});
