<?php

use App\Http\Controllers\API\RegisterController;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/stocks/{symbol}', \App\Http\Controllers\API\StocksAPIController::class);
    Route::resource('/stocks', \App\Http\Controllers\API\StocksController::class);
});
