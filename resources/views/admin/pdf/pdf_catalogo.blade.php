<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Catálogo de Pasteles — Amoretti</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #1c1b1b;
            background: #fff;
        }

        .header {
            background: #973100;
            color: #fff;
            padding: 18px 24px;
            margin-bottom: 20px;
        }

        .header-top {
            display: table;
            width: 100%;
        }

        .header-left  { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }

        .brand {
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: -0.5px;
            font-family: 'DejaVu Serif', serif;
        }

        .brand-sub { font-size: 8pt; opacity: 0.75; margin-top: 2px; }
        .report-title { font-size: 13pt; font-weight: bold; }
        .report-meta  { font-size: 8pt; opacity: 0.8; margin-top: 3px; }

        .filter-bar {
            background: #fff1ec;
            border: 1px solid #e1bfb4;
            border-radius: 6px;
            padding: 7px 14px;
            font-size: 8.5pt;
            color: #594139;
            margin-bottom: 14px;
        }

        .filter-bar strong { color: #973100; }

        .metrics {
            display: table;
            width: 100%;
            margin-bottom: 16px;
            border-spacing: 8px;
        }

        .metric-cell {
            display: table-cell;
            width: 25%;
            background: #f6f3f2;
            border: 1px solid #e1bfb4;
            border-radius: 6px;
            padding: 10px 12px;
            text-align: center;
        }

        .metric-val {
            font-size: 18pt;
            font-weight: bold;
            color: #973100;
            font-family: 'DejaVu Serif', serif;
        }

        .metric-lbl {
            font-size: 7.5pt;
            color: #594139;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #3d1f0d; color: #fff; }

        thead th {
            padding: 9px 10px;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr:nth-child(even) { background: #fdf8f4; }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #ede8e5;
            vertical-align: middle;
        }

        .td-nombre { font-weight: bold; font-size: 9.5pt; }
        .td-sabor  { color: #594139; font-size: 8.5pt; font-style: italic; }
        .td-precio { font-weight: bold; color: #973100; }

        .cat-pill {
            background: #ffdbcf;
            color: #973100;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 7.5pt;
            font-weight: bold;
        }

        .stock-ok  { color: #16a34a; font-weight: bold; }
        .stock-low { color: #d97706; font-weight: bold; }
        .stock-out { color: #dc2626; font-weight: bold; }

        .st-on  { color: #16a34a; font-weight: bold; }
        .st-off { color: #dc2626; font-weight: bold; }

        .group-header td {
            background: #f0eded;
            font-size: 8pt;
            font-weight: bold;
            color: #3d1f0d;
            padding: 6px 10px;
            border-top: 2px solid #e1bfb4;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .totals-row td {
            background: #fff1ec;
            border-top: 2px solid #973100;
            font-weight: bold;
            padding: 8px 10px;
            color: #3d1f0d;
        }

        .footer {
            margin-top: 20px;
            border-top: 1px solid #e1bfb4;
            padding-top: 8px;
            display: table;
            width: 100%;
        }

        .footer-left  { display: table-cell; font-size: 7.5pt; color: #9e8880; }
        .footer-right { display: table-cell; text-align: right; font-size: 7.5pt; color: #9e8880; }

        @page { margin: 18mm 16mm 18mm 16mm; }

        .thumb {
            width: 42px;
            height: 42px;
            border-radius: 6px;
            overflow: hidden;
            background: #f3f3f3;
        }

        .thumb img {
            width: 42px;
            height: 42px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div class="header-left">
            <div class="brand">Amoretti</div>
            <div class="brand-sub">Pastelería Artesanal · San Luis Potosí</div>
        </div>
        <div class="header-right">
            <div class="report-title">Catálogo de Pasteles</div>
            <div class="report-meta">Generado: {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>

@if($categoriaSeleccionada !== 'Todas las categorías')
    <div class="filter-bar">
        Filtrado por categoría: <strong>{{ $categoriaSeleccionada }}</strong>
    </div>
@else
    <div class="filter-bar">
        Reporte general: <strong>Todas las categorías</strong>
    </div>
@endif

@php
    $totalProductos   = $productos->count();
    $totalDisponibles = $productos->where('disponible', true)->count();
    $sinStock         = $productos->where('stock', 0)->count();
    $valorInventario  = $productos->sum(fn($p) => $p->precio * $p->stock);
@endphp

<div class="metrics">
    <div class="metric-cell">
        <div class="metric-val">{{ $totalProductos }}</div>
        <div class="metric-lbl">Total pasteles</div>
    </div>
    <div class="metric-cell">
        <div class="metric-val">{{ $totalDisponibles }}</div>
        <div class="metric-lbl">Disponibles</div>
    </div>
    <div class="metric-cell">
        <div class="metric-val">{{ $sinStock }}</div>
        <div class="metric-lbl">Sin stock</div>
    </div>
    <div class="metric-cell">
        <div class="metric-val">${{ number_format($valorInventario, 0) }}</div>
        <div class="metric-lbl">Valor inventario</div>
    </div>
</div>

@php $categoriaActual = null; @endphp

<table>
    <thead>
        <tr>
            <th style="width:10%;">Imagen</th>
            <th style="width:22%;">Nombre</th>
            <th style="width:18%;">Sabor</th>
            <th style="width:14%;">Categoría</th>
            <th style="width:12%;">Tamaño</th>
            <th style="width:10%;">Precio</th>
            <th style="width:7%;">Stock</th>
            <th style="width:7%;">Disponible</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
            @if($categoriaActual !== $producto->categoria)
                @php $categoriaActual = $producto->categoria; @endphp
                <tr class="group-header">
                    <td colspan="8">{{ $producto->categoria }}</td>
                </tr>
            @endif

            <tr>
                <td>
                    @if($producto->imagen)
                        @php $rutaImagen = public_path('storage/' . $producto->imagen); @endphp
                        @if(file_exists($rutaImagen))
                            <div class="thumb">
                                <img src="{{ $rutaImagen }}" alt="{{ $producto->nombre }}">
                            </div>
                        @endif
                    @endif
                </td>
                <td class="td-nombre">{{ $producto->nombre }}</td>
                <td class="td-sabor">{{ $producto->sabor }}</td>
                <td><span class="cat-pill">{{ $producto->categoria }}</span></td>
                <td style="font-size:8pt;color:#594139;">{{ $producto->tamano }}</td>
                <td class="td-precio">${{ number_format($producto->precio, 0) }}</td>
                <td>
                    @if($producto->stock > 10)
                        <span class="stock-ok">{{ $producto->stock }}</span>
                    @elseif($producto->stock > 0)
                        <span class="stock-low">{{ $producto->stock }}</span>
                    @else
                        <span class="stock-out">0</span>
                    @endif
                </td>
                <td>
                    @if($producto->disponible)
                        <span class="st-on">Sí</span>
                    @else
                        <span class="st-off">No</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:20px;color:#594139;">
                    No hay productos con los filtros aplicados.
                </td>
            </tr>
        @endforelse

        @if($productos->count() > 0)
            <tr class="totals-row">
                <td colspan="5">Total registros</td>
                <td>{{ $totalProductos }}</td>
                <td colspan="2"></td>
            </tr>
        @endif
    </tbody>
</table>

<div class="footer">
    <div class="footer-left">Amoretti Pastelería · Reporte confidencial · Solo para uso interno</div>
    <div class="footer-right">{{ now()->format('d \d\e F \d\e Y') }}</div>
</div>

</body>
</html>