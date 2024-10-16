<?php

use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductApiController::class)->group(function () {
    Route::get('create-product', 'createProduct');
});

Route::controller(CategoryApiController::class)->group(function () {
    Route::get('fetch-category', 'fetchCategories');
});
