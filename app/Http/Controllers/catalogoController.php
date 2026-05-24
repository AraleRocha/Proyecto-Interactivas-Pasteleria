<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\producto;

class catalogoController extends Controller
{
    public function index()
    {
        $productos = producto::where('disponible', true)
            ->where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();
 
        return view('client.catalogo', compact('productos'));
    }
 
    /* Detalle público de un pastel*/
    public function show(string $id)
    {
        $producto = producto::where('id', $id)
            ->where('disponible', true)
            ->firstOrFail();
 
        $sugerencias = Producto::where('disponible', true)
            ->where('stock', '>', 0)
            ->where('categoria', $producto->categoria)
            ->where('id', '!=', $producto->id)
            ->limit(3)
            ->get();
 
        return view('client.catalogo_detalle', compact('producto', 'sugerencias'));
    }
}
