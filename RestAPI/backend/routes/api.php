<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatController;

Route::get('/cats', [CatController::class, 'index']);
Route::get('/cats/{id}', [CatController::class, 'show']);
Route::post('/cats', [CatController::class, 'store']);
Route::put('/cats/{id}', [CatController::class, 'update']);
Route::delete('/cats/{id}', [CatController::class, 'destroy']);