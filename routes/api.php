<?php

use App\Http\Controllers\TraitementController;
use Illuminate\Support\Facades\Route;

Route::apiResource('traitments',TraitementController::class);
Route::get('/traitment/search',[TraitementController::class,'search'])->name('search');

Route::get('/test', function () {
    return response()->json(['message' => 'API working']);
});