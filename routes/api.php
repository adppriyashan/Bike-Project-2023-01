<?php

use App\Http\Controllers\APIUserController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('/login',[APIUserController::class,'login']);
    Route::post('/register',[APIUserController::class,'register']);
});
Route::prefix('/bikes')->group(function () {
    Route::get('/get-available',[BikeController::class,'getAvailable']);
    Route::get('/get-available-by-order',[BikeController::class,'getAvailableNearByOrder']);
});
Route::prefix('/reservation')->group(function () {
    Route::get('/qrscan',[ReservationController::class,'reserveByQRCode']);
});
Route::prefix('/mapping')->group(function () {
    Route::get('/record/{mac}/{lng}/{ltd}/{reservation}',[MappingController::class,'mapData']);
});
