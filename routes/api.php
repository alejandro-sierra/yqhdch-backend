<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/pruebas', function(){
        return "pruebas";
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
