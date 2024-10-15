<?php

use App\Http\Controllers\ProductApiController;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductApiController::class)->group(function () {
    Route::get('create-product', 'createProduct');
});