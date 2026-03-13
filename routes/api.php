<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return 'Olá';
});

Route::get('/users', function (Request $request) {
    return [
        ['id' => 1, 'name' => 'João'],
        ['id' => 2, 'name' => 'Maria'],
        ['id' => 3, 'name' => 'José'],
    ];
});

Route::get('/products', function (Request $request) {
    return [
        ['id' => 1, 'name' => 'Produto 1', 'price' => 10.00],
        ['id' => 2, 'name' => 'Produto 2', 'price' => 20.00],
        ['id' => 3, 'name' => 'Produto 3', 'price' => 30.00],
    ];
});
