<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registrar', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::post('/validar',[UserController::class, 'validarToken']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::middleware('auth:sanctum')->apiResource('produto', ProdutoController::class);
});
