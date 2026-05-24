<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*Rutas de las apis*/

// Publicas
Route::post('/login', [ApiController::class, 'login']);
Route::get ('/productos', [ApiController::class, 'catalogo']);
Route::get ('/productos/{id}', [ApiController::class, 'detalle']);

// protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pedidos', [ApiController::class, 'agregarPedido']);
});