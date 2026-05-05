<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\producto;

class productosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = producto::all();
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'sabor'       => 'required|string|max:255',
            'tamaño'      => 'required|string|max:255',
            'categoria'   => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'disponible'  => 'nullable|boolean',
            'imagen'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['disponible'] = $request->boolean('disponible');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = producto::findOrFail($id);

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
