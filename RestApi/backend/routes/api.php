<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;

Route::apiResource('films', FilmController::class);