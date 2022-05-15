<?php

use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Constants routes
const BASE_ROUTE_RECIPE = "/recipes";
const GET_RECIPE_RANDOM = "/recipe";

const GETALL = BASE_ROUTE_RECIPE . "";
const CREATE = BASE_ROUTE_RECIPE . "/create";
const DELETE = BASE_ROUTE_RECIPE . "/delete/{id?}";


// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get(GETALL, [RecipeController::class, 'recipes'])->name('recipes');
Route::post(CREATE, [RecipeController::class, 'create'])->name('create');
Route::delete(DELETE, [RecipeController::class, 'delete'])->name('delete');


Route::get(GET_RECIPE_RANDOM, [RecipeController::class, 'recipe'])->name('recipe');


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
});
