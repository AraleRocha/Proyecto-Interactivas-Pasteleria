<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productosController;
use App\Http\Controllers\pedidosController;
use App\Http\Controllers\catalogoController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//Rutas para admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('productos', productosController::class);
});

//Rutas para el cliente
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/', [catalogoController::class, 'index'])->name('catalogo.index');
    Route::get('/pastel/{id}', [catalogoController::class, 'show'])->name('catalogo.show');
    
    // Carrito sesión
    Route::get   ('/carrito',      [CarritoController::class, 'index'])     ->name('carrito.index');
    Route::post  ('/carrito/{id}', [CarritoController::class, 'agregar'])   ->name('carrito.agregar');
    Route::patch ('/carrito/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])  ->name('carrito.eliminar');
    Route::delete('/carrito',      [CarritoController::class, 'vaciar'])    ->name('carrito.vaciar');
 
    // Pedidos
    Route::get ('/pedidos',                    [PedidosController::class, 'index'])       ->name('pedidos.index');
    Route::get ('/pedidos/{pedido}',           [PedidosController::class, 'show'])        ->name('pedidos.show');
    Route::post('/pedidos/agregar',            [PedidosController::class, 'agregar'])     ->name('pedidos.agregar');
    Route::post('/pedidos/{pedido}/confirmar', [PedidosController::class, 'confirmar'])   ->name('pedidos.confirmar');
    Route::post('/pedidos/{pedido}/comprar',   [PedidosController::class, 'comprar'])     ->name('pedidos.comprar');
    Route::post('/pedidos/{pedido}/cancelar',  [PedidosController::class, 'cancelar'])    ->name('pedidos.cancelar');
    Route::patch('/pedidos/{pedido}/estado',   [PedidosController::class, 'updateEstado'])->name('pedidos.estado');
 
    //Pedidos para admin
    Route::post('/pedidos/{pedido}/aprobar',   [PedidosController::class, 'aprobar'])->name('pedidos.aprobar');
    Route::post('/pedidos/{pedido}/rechazar',  [PedidosController::class, 'rechazar'])->name('pedidos.rechazar');
    Route::post('/pedidos/{pedido}/listo',     [PedidosController::class, 'marcarListo'])->name('pedidos.listo');

    // Ítems del pedido
    Route::patch ('/pedido-items/{item}', [PedidosController::class, 'updateItem'])  ->name('pedido-items.update');
    Route::delete('/pedido-items/{item}', [PedidosController::class, 'destroyItem']) ->name('pedido-items.destroy');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
