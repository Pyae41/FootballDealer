<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Client\ClientController;
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
// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login',  'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});


// Admin
Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {

        // Admin Control

        // Get Users List or Admin List
        Route::post('home', 'index');

        // Add Point
        Route::post('add_point/{id}', 'addPoint');


        // Admin Control

        // User Control

        // Withdraw Point
        // Withdraw Point

        // User Control
});

// Client
Route::prefix('client')->controller(ClientController::class)->group(function () {

    // Get User data
    Route::get('user', [ClientController::class, 'getUserData']);

    // Get Matches odds for bet
    // Bet history
    // Withdraw history

});

Route::get('/hello',function(){
    return 'hello';
});
