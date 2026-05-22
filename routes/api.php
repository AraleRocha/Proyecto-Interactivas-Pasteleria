<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Amoretti
| Autenticación: Laravel Sanctum
| Header requerido en rutas 🔒: Authorization: Bearer {token}
|                                Accept: application/json
|--------------------------------------------------------------------------
*/

// ── PÚBLICAS ───────────────────────────────────────────────────────────
Route::post('/login',           [ApiController::class, 'login']);
Route::get ('/productos',       [ApiController::class, 'catalogo']);
Route::get ('/productos/{id}',  [ApiController::class, 'detalle']);

// ── PROTEGIDAS con Sanctum ─────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pedidos', [ApiController::class, 'agregarPedido']);
});