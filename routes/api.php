<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registrar', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/usuarios', [UserController::class, 'index']);