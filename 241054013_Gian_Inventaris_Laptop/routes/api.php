<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaptopApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/laptops', [LaptopApiController::class, 'index']);
Route::get('/laptops/{id}', [LaptopApiController::class, 'show']);
Route::post('/laptops', [LaptopApiController::class, 'store']);
Route::put('/laptops/{id}', [LaptopApiController::class, 'update']);
Route::delete('/laptops/{id}', [LaptopApiController::class, 'destroy']);