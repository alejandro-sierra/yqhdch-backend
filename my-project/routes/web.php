<?php

use App\Http\Controllers\WebScrapingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("scraping", [WebScrapingController::class, "scraping"])->name("scraping");