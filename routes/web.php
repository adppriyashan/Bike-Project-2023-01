<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'permitted']);

Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [UserController::class, 'enroll'])->name('admin.users.enroll')->middleware(['auth']);
    Route::get('/list', [UserController::class, 'list'])->name('admin.users.list')->middleware(['auth']);
    Route::get('/get', [UserController::class, 'getOne'])->name('admin.users.get.one')->middleware(['auth']);
    Route::get('/delete', [UserController::class, 'deleteOne'])->name('admin.users.delete.one')->middleware(['auth']);
    Route::get('/find', [UserController::class, 'find'])->name('admin.users.find.one')->middleware(['auth']);
});

Route::prefix('/usertypes')->group(function () {
    Route::get('/', [UserTypeController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [UserTypeController::class, 'enroll'])->name('admin.usertypes.enroll')->middleware(['auth']);
    Route::get('/list', [UserTypeController::class, 'list'])->name('admin.usertypes.list')->middleware(['auth']);
    Route::get('/get', [UserTypeController::class, 'getOne'])->name('admin.usertypes.get.one')->middleware(['auth']);
    Route::get('/delete', [UserTypeController::class, 'deleteOne'])->name('admin.usertypes.delete.one')->middleware(['auth']);
});
