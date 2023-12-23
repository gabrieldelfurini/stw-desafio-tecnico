<?php

use App\Http\Controllers\Api\IngredienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ingredientes', [IngredienteController::class, 'index']);
Route::post('ingredientes', [IngredienteController::class, 'store']);
Route::get('ingredientes/{id}', [IngredienteController::class, 'show']);
Route::get('ingredientes/{id}/edit', [IngredienteController::class, 'edit']);
Route::put('ingredientes/{id}/edit', [IngredienteController::class, 'update']);
Route::delete('ingredientes/{id}/delete', [IngredienteController::class, 'destroy']);

