<?php

use App\Http\Controllers\ShipController;
use Illuminate\Support\Facades\Route;

Route::prefix('/boat')->group(function () {
    Route::get('history/enroll', [ShipController::class, 'enrollRecords']);
    Route::get('emergency/enroll', [ShipController::class, 'enrollEmergency']);
});
