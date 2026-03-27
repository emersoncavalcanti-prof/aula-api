<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/usuarios', [UserController::class, 'index']);
Route::post('/registrar', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/validar',[UserController::class, 'validarToken']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);