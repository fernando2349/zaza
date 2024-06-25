<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\Api\ClientesController;
use App\Http\Controllers\Api\ProductoController;


Route::get('/clientes', [ClientesController::class, 'index']);

Route::get('/clientes/{id}', [ClientesController::class, 'show'] );

Route::post('/clientes', [ClientesController::class, 'store']);

Route::put('/clientes/{id}', [ClientesController::class, 'update']);

Route::delete('/clientes/{id}', [ClientesController::class, 'destroy']);

// controladores producto
Route::get('/productos', [ProductoController::class, 'index']);

Route::get('/productos/{id}', [ProductoController::class, 'show']);

 Route::post('/productos', [ProductoController::class, 'store']);

 Route::put('/productos/{id}', [ProductoController::class, 'update']);

Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);



