<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Producto;

class ProductosController extends Controller
{
    //Listado de productos
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos', compact('productos'));
    }

    //Formulario de creación
    public function create()
    {
        return view('admin.producto_nuevo');
    }

    //Guardar nuevo producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'sabor' => 'required|string|max:255',
            'tamano' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'disponible' => 'nullable|boolean',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['disponible'] = $request->boolean('disponible');

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    // Formulario de edición
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.producto_modifica', compact('producto'));
    }

    //Actualizar producto existente
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'sabor' => 'required|string|max:255',
            'tamano' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'disponible' => 'nullable|boolean',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'eliminar_imagen' => 'nullable|boolean',
        ]);

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['disponible'] = $request->boolean('disponible');

        // Si se sube nueva imagen la reemplaza
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');

        // Si se marca eliminar imagen sin subir nueva: borrar y dejar null
        } elseif ($request->boolean('eliminar_imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validated['imagen'] = null;

        // Ninguna acción sobre imagen: conservar la actual
        } else {
            unset($validated['imagen']);
        }

        // Limpiar campos auxiliares que no son columnas de la tabla
        unset($validated['eliminar_imagen']);

        $producto->update($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    //Eliminar producto
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}