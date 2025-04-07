<?php

use App\Http\Controllers\ProductService\ProductServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('product-service', ProductServiceController::class);
