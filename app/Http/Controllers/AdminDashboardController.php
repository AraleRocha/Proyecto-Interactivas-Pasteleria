<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPedidos = Pedido::where('estado', '!=', 'borrador')->count();
        $totalProductos = Producto::count();
        $stockBajo = Producto::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $sinStock = Producto::where('stock', 0)->count();

        $estados = ['pendiente', 'por_confirmar', 'horneando', 'listo', 'rechazado', 'cancelado', 'entregado'];

        $pedidosEstadosRaw = Pedido::selectRaw('estado, COUNT(*) as total')
            ->where('estado', '!=', 'borrador')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $pedidosLabels = collect($estados)->map(function ($estado) {
            return ucfirst(str_replace('_', ' ', $estado));
        })->values();

        $pedidosData = collect($estados)->map(function ($estado) use ($pedidosEstadosRaw) {
            return (int) ($pedidosEstadosRaw[$estado] ?? 0);
        })->values();

        $productosCategoriasRaw = Producto::selectRaw('categoria, COUNT(*) as total')
            ->groupBy('categoria')
            ->orderBy('categoria')
            ->pluck('total', 'categoria');

        $productosCategoriasLabels = $productosCategoriasRaw->keys()->values();
        $productosCategoriasData = $productosCategoriasRaw->values()->map(fn ($v) => (int) $v)->values();

        return view('admin.dashboard', compact(
            'totalPedidos',
            'totalProductos',
            'stockBajo',
            'sinStock',
            'pedidosLabels',
            'pedidosData',
            'productosCategoriasLabels',
            'productosCategoriasData'
        ));
    }
}