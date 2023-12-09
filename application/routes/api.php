<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpeedwayController;
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

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {

    Route::apiResource('race', RaceController::class);
    Route::prefix('race')->controller(RaceController::class)->group(function () {
        Route::post('/attach/drivers', 'attachDrivers');
        Route::post('/cancel/{id}', 'cancelRace');
    });    

    Route::apiResource('speedway', SpeedwayController::class);

    Route::apiResource('driver', DriverController::class);

    Route::apiResource('car', CarController::class);

});