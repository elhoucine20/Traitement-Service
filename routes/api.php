<?php

use App\Http\Controllers\TraitementController;
use Illuminate\Support\Facades\Route;

Route::apiResource('traitments',TraitementController::class);

