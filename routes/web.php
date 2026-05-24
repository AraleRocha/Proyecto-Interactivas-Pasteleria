<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productosController;
use App\Http\Controllers\pedidosController;
use App\Http\Controllers\catalogoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Mail\Bienvenida;
use App\Models\User;
use App\Http\Controllers\ChatbotController;

Route::view('/', 'welcome');

/*Dashboard automático según rol*/
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*Rutas para administradores*/
Route::middleware(['auth', 'verified', 'can:admin-access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*CRUD de productos/pasteles */
        Route::resource('productos', productosController::class);

        /*CRUD de usuarios*/
        Route::resource('usuarios', UserController::class);

        /*CRUD de pedidos para administradores, editar estados*/
        Route::get('/pedidos', [pedidosController::class, 'index'])
            ->name('pedidos.index');

        Route::get('/pedidos/{pedido}', [pedidosController::class, 'show'])
            ->name('pedidos.show');

        Route::patch('/pedidos/{pedido}/estado', [pedidosController::class, 'updateEstado'])
            ->name('pedidos.estado');

        Route::post('/pedidos/{pedido}/aprobar', [pedidosController::class, 'aprobar'])
            ->name('pedidos.aprobar');

        Route::post('/pedidos/{pedido}/rechazar', [pedidosController::class, 'rechazar'])
            ->name('pedidos.rechazar');

        Route::post('/pedidos/{pedido}/listo', [pedidosController::class, 'marcarListo'])
            ->name('pedidos.listo');

        /*Reporte de los pasteles (por medio de un filtro)*/
        Route::get('/reportes/pasteles/pdf', [ReporteController::class, 'catalogoStream'])
            ->name('reportes.pasteles.stream');

        Route::get('/reportes/pasteles/descargar', [ReporteController::class, 'catalogoDescargar'])
            ->name('reportes.pasteles.descargar');

        Route::get('/reportes/pasteles', [ReporteController::class, 'catalogoVista'])
            ->name('reportes.pasteles.vista');
    });


/*Rutas para clientes*/
Route::middleware(['auth', 'verified', 'can:client-access'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {

        /*dashboard*/
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])
            ->name('dashboard');

        /*catalogo de pasteles*/
        Route::get('/catalogo', [catalogoController::class, 'index'])
            ->name('catalogo.index');

        Route::get('/pastel/{id}', [catalogoController::class, 'show'])
            ->name('catalogo.show');

        /*CRUD de pedidos para clientes, crear, editar y eliminar*/
        Route::get('/pedidos', [pedidosController::class, 'index'])
            ->name('pedidos.index');

        Route::get('/pedidos/{pedido}', [pedidosController::class, 'show'])
            ->name('pedidos.show');

        Route::post('/pedidos/agregar', [pedidosController::class, 'agregar'])
            ->name('pedidos.agregar');

        Route::post('/pedidos/{pedido}/confirmar', [pedidosController::class, 'confirmar'])
            ->name('pedidos.confirmar');

        Route::post('/pedidos/{pedido}/comprar', [pedidosController::class, 'comprar'])
            ->name('pedidos.comprar');

        Route::post('/pedidos/{pedido}/cancelar', [pedidosController::class, 'cancelar'])
            ->name('pedidos.cancelar');

        Route::post('/chatbot', [ChatbotController::class, 'responder'])->name('chatbot.responder');
        
        /*Items del pedido*/
        Route::patch('/pedido-items/{item}', [pedidosController::class, 'updateItem'])
            ->name('pedido-items.update');

        Route::delete('/pedido-items/{item}', [pedidosController::class, 'destroyItem'])
            ->name('pedido-items.destroy');
    });


/*Perfil*/
Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__.'/auth.php';