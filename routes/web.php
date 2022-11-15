<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('profile/new/token', [AuthenticatedSessionController::class, 'profileNewToken'])->name('profile.new.token');
        
    });

    Route::get('profile', [AuthenticatedSessionController::class, 'profile'])->name('profile');
});

require __DIR__.'/auth.php';
