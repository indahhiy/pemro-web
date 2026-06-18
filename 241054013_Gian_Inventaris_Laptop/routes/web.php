<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;

Route::get('/', [LaptopController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/laptops', [LaptopController::class, 'index'])
    ->name('laptops.index');

Route::get('/laptops/create', [LaptopController::class, 'create'])
    ->name('laptops.create');

Route::post('/laptops', [LaptopController::class, 'store']);

Route::get('/laptops/{id}/edit', [LaptopController::class, 'edit']);

Route::put('/laptops/{id}', [LaptopController::class, 'update']);

Route::delete('/laptops/{id}', [LaptopController::class, 'destroy']);

Route::get('/laptops/export/pdf', [LaptopController::class, 'exportPdf']);

Route::get('/laptops-api', function () { return view('laptops.api'); });