<?php

use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// *** PUBLIC ROUTES ***
// [ RECIPES ]
const BASE_ROUTE_RECIPE = "/recipes";

const GETALL_RECIPES = BASE_ROUTE_RECIPE . "";
const GET_RECIPE_RANDOM = "/recipe/{number?}/{time?}/{difficulty?}/{diet?}";
const CREATE_RECIPE = BASE_ROUTE_RECIPE . "/create";
const DELETE_RECIPE = BASE_ROUTE_RECIPE . "/delete/{id?}";

const GET_PREPARATION_TIMES = BASE_ROUTE_RECIPE . "/times";
const GET_DIET = BASE_ROUTE_RECIPE . "/diets";
const GET_DIFFICULTY = BASE_ROUTE_RECIPE . "/difficulties";


Route::get(GET_RECIPE_RANDOM, [RecipeController::class, 'recipe'])->name('recipe');
Route::get(GETALL_RECIPES, [RecipeController::class, 'recipes'])->name('recipes');
Route::get(GET_PREPARATION_TIMES, [RecipeController::class, 'getPreparationTimes'])->name('getPreparationTimes');
Route::get(GET_DIET, [RecipeController::class, 'getDiets'])->name('getDiets');
Route::get(GET_DIFFICULTY, [RecipeController::class, 'getDifficulties'])->name('getDifficulties');
Route::post(CREATE_RECIPE, [RecipeController::class, 'create'])->name('create');


// [ AUTH ]
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');



// *** PROTECTED ROUTES ***
Route::group(['middleware' => ['auth:sanctum']], function () {
    // [ RECIPES ]
    Route::delete(DELETE_RECIPE, [RecipeController::class, 'delete'])->name('delete');

    // [ AUTH ]
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');
});
