<?php

use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const BASE_ROUTE_RECIPE = "/recipes";
const GETALL_RECIPES = BASE_ROUTE_RECIPE . "";


// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get(GETALL_RECIPES, [RecipeController::class, 'recipes'])->name('recipes');


Route::get('/recipeRandom', [RecipeController::class, 'recipeRandom'])->name('recipeRandom');


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    
    Route::get('/pruebas', function(){ return "pruebas"; });
});
