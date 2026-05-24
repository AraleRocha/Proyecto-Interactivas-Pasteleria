<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Producto;
use App\Models\Pedido;

class ReporteController extends Controller
{
    public function catalogoVista(Request $request)
    {
        $query = Producto::orderBy('categoria')->orderBy('nombre');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get();
        $categoriaSeleccionada = $request->categoria ?? 'Todas las categorías';

        return view('admin.reportes.catalogo', compact('productos', 'categoriaSeleccionada'));
    }

    //Descargar PDF
    public function catalogoDescargar(Request $request)
    {
        $query = Producto::orderBy('categoria')->orderBy('nombre');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get();
        $categoriaSeleccionada = $request->categoria ?? 'Todas las categorías';

        $pdf = Pdf::loadView('admin.pdf.pdf_catalogo', compact('productos', 'categoriaSeleccionada'))
            ->setPaper('letter', 'portrait');

        $slug = Str::slug($categoriaSeleccionada);

        return $pdf->download('catalogo-pasteles-' . $slug . '-' . now()->format('Ymd') . '.pdf');
    }

    //Ver PDF
    public function catalogoStream(Request $request)
    {
        $query = Producto::orderBy('categoria')->orderBy('nombre');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get();
        $categoriaSeleccionada = $request->categoria ?? 'Todas las categorías';

        return Pdf::loadView('admin.pdf.pdf_catalogo', compact('productos', 'categoriaSeleccionada'))
            ->setPaper('letter', 'portrait')
            ->stream('catalogo-pasteles.pdf');
    }
}