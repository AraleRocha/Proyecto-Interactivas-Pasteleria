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

Route::view('/', 'welcome');

Route::get('/preview-correo', function () {

    $user = User::first();

    return new Bienvenida($user);

});
/*
|--------------------------------------------------------------------------
| Dashboard automático según rol
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('client.dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:admin-access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Cliente
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:client-access'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {

        Route::get('/dashboard', [ClientDashboardController::class, 'index'])
            ->name('dashboard');
    });


//Rutas para admin
Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('productos', productosController::class);
    Route::resource('usuarios', UserController::class);
});


//Rutas para el cliente
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [catalogoController::class, 'index'])->name('catalogo.index');

    Route::get('/pastel/{id}', [catalogoController::class, 'show'])->name('catalogo.show');
    
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


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/reportes/pasteles/pdf', [ReporteController::class, 'catalogoStream'])
        ->name('reportes.pasteles.stream');

    Route::get('/reportes/pasteles/descargar', [ReporteController::class, 'catalogoDescargar'])
        ->name('reportes.pasteles.descargar');

    Route::get('/reportes/pasteles', [ReporteController::class, 'catalogoVista'])
        ->name('reportes.pasteles.vista');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';