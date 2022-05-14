<?php

use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const BASE_ROUTE_RECIPE = "/recipes";
const GETALL_RECIPE = "";


// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get(BASE_ROUTE_RECIPE . GETALL_RECIPE, [RecipeController::class, 'getAll'])->name('getAllRecipes');


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    
    Route::get('/pruebas', function(){ return "pruebas"; });
});
