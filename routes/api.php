<?php

use App\Http\Controllers\APIUserController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('/login', [APIUserController::class, 'login']);
    Route::post('/register', [APIUserController::class, 'register']);
});
Route::prefix('/bikes')->group(function () {
    Route::get('/get-available', [BikeController::class, 'getAvailable']);
    Route::get('/get-available-by-order', [BikeController::class, 'getAvailableNearByOrder']);
});
Route::prefix('/reservation')->group(function () {
    Route::get('/availability', [ReservationController::class, 'checkAvailabilityByQRCode']);
    Route::get('/qrscan', [ReservationController::class, 'reserveByQRCode']);
    Route::get('/hour', [ReservationController::class, 'reserveByHour']);
    Route::get('/finish', [ReservationController::class, 'finishReservation']);
    Route::get('/lock', [ReservationController::class, 'lockStatus']);
    Route::get('/newride', [ReservationController::class, 'newride']);
    Route::get('/history', [ReservationController::class, 'historyList']);
});
Route::prefix('/mapping')->group(function () {
    Route::get('/record/{mac}/{lng}/{ltd}/{reservation}', [MappingController::class, 'mapData']);
    Route::get('/factors/{mac}/{intensity}/{temperature}/{humidity}/{air_quality}/{rainy}/{waterlevel}', [MappingController::class, 'factorData']);
});
Route::prefix('/user')->group(function () {
    Route::get('/leaderboard', [UserController::class, 'getLeaderBoard']);
});
Route::prefix('/emergency')->group(function () {
    Route::get('/inform', [UserController::class, 'informEmergency']);
});
