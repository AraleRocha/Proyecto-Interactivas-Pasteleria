<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Catálogo — Amoretti</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 8.5pt;
    color: #2a1810;
    background: #fff;
}

/* ── HEADER ── */
.header {
    margin-bottom: 18px;
}
.header-band {
    display: table;
    width: 100%;
    background: #973100;
}
.header-logo-cell {
    display: table-cell;
    vertical-align: middle;
    padding: 16px 22px;
    width: 40%;
}
.header-title-cell {
    display: table-cell;
    vertical-align: middle;
    padding: 16px 22px;
    text-align: right;
    background: #3d1f0d;
}
.brand {
    font-family: 'DejaVu Serif', serif;
    font-size: 24pt;
    font-weight: bold;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.5px;
}
.brand-tagline {
    font-size: 7pt;
    color: rgba(255,220,210,0.7);
    margin-top: 4px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}
.report-name {
    font-size: 12pt;
    font-weight: bold;
    color: #fff;
    margin-bottom: 4px;
}
.report-date {
    font-size: 7.5pt;
    color: rgba(255,255,255,0.45);
}
.header-accent {
    height: 3px;
    background: #fecbc6;
    width: 100%;
}

/* ── FILTRO ── */
.filter-row {
    display: table;
    width: 100%;
    margin-bottom: 14px;
    border: 1px solid #e8cfc8;
    border-radius: 4px;
    background: #fff8f6;
}
.filter-label {
    display: table-cell;
    padding: 6px 14px;
    font-size: 7.5pt;
    color: #973100;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    vertical-align: middle;
    background: #fff1ec;
    width: 120px;
    border-right: 1px solid #e8cfc8;
}
.filter-value {
    display: table-cell;
    padding: 6px 14px;
    font-size: 8pt;
    color: #594139;
    vertical-align: middle;
}

/* ── MÉTRICAS ── */
.metrics-row {
    display: table;
    width: 100%;
    margin-bottom: 18px;
}
.metric-col {
    display: table-cell;
    width: 25%;
    padding: 0 5px 0 0;
}
.metric-col:last-child { padding-right: 0; }
.metric-box {
    border: 1px solid #e8cfc8;
    border-radius: 5px;
    overflow: hidden;
}
.metric-top {
    background: #973100;
    padding: 7px 12px;
    text-align: center;
}
.metric-num {
    font-family: 'DejaVu Serif', serif;
    font-size: 20pt;
    font-weight: bold;
    color: #fff;
    line-height: 1;
}
.metric-bottom {
    background: #fff8f6;
    padding: 5px 12px;
    text-align: center;
}
.metric-lbl {
    font-size: 6.5pt;
    color: #9e7a72;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

/* ── TABLA ── */
.table-wrap {
    border: 1px solid #ddd0cc;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 16px;
}

table { width: 100%; border-collapse: collapse; }

thead tr {
    background: #3d1f0d;
}
thead th {
    padding: 9px 10px;
    font-size: 6.5pt;
    font-weight: bold;
    color: rgba(255,255,255,0.85);
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}
thead th.right { text-align: right; }
thead th.center { text-align: center; }

.group-row td {
    background: #f5efec;
    padding: 5px 10px;
    border-top: 1px solid #ddd0cc;
    border-bottom: 1px solid #ddd0cc;
    font-size: 7pt;
    font-weight: bold;
    color: #973100;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}
.group-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #973100;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
}

tbody tr.data-odd  { background: #fff; }
tbody tr.data-even { background: #fdf8f6; }

tbody td {
    padding: 7px 10px;
    border-bottom: 1px solid #f0e8e4;
    vertical-align: middle;
    font-size: 8pt;
}
tbody tr:last-child td { border-bottom: none; }

.td-nombre { font-weight: bold; font-size: 8.5pt; color: #2a1810; }
.td-sabor  { color: #7a5a52; font-style: italic; font-size: 7.5pt; }
.td-precio {
    font-family: 'DejaVu Serif', serif;
    font-weight: bold;
    color: #973100;
    font-size: 9.5pt;
    text-align: right;
}
.td-center { text-align: center; }

.cat-pill {
    background: #ffdbcf;
    color: #7a2800;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 6.5pt;
    font-weight: bold;
}

.stock-ok  { color: #15803d; font-weight: bold; }
.stock-low { color: #b45309; font-weight: bold; }
.stock-out { color: #b91c1c; font-weight: bold; }
.st-on     { color: #15803d; font-weight: bold; }
.st-off    { color: #b91c1c; font-weight: bold; }

/* ── THUMB ── */
.thumb     { width: 34px; height: 34px; border-radius: 4px; overflow: hidden; background: #f3eeec; }
.thumb img { width: 34px; height: 34px; object-fit: cover; }
.thumb-ph  { width: 34px; height: 34px; border-radius: 4px; background: #ede8e5; text-align: center; line-height: 34px; font-size: 7pt; color: #b8a09a; }

/* ── FILA TOTALES ── */
.totals-row td {
    background: #3d1f0d;
    color: #fff;
    font-weight: bold;
    padding: 8px 10px;
    font-size: 8pt;
}
.totals-row td.total-num {
    font-family: 'DejaVu Serif', serif;
    font-size: 10pt;
    color: #fecbc6;
    text-align: right;
}

/* ── FOOTER ── */
.footer {
    display: table;
    width: 100%;
    border-top: 2px solid #973100;
    padding-top: 8px;
    margin-top: 4px;
}
.footer-left {
    display: table-cell;
    font-size: 7pt;
    color: #9e7a72;
    vertical-align: bottom;
}
.footer-brand {
    font-family: 'DejaVu Serif', serif;
    font-size: 10pt;
    font-weight: bold;
    color: #973100;
    margin-bottom: 2px;
}
.footer-right {
    display: table-cell;
    text-align: right;
    vertical-align: bottom;
}
.footer-stamp {
    display: inline-block;
    background: #973100;
    color: #fff;
    font-size: 7pt;
    font-weight: bold;
    padding: 3px 10px;
    border-radius: 3px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

@page { margin: 13mm 13mm 13mm 13mm; }
</style>
</head>
<body>

<div class="header">
    <div class="header-band">
        <div class="header-logo-cell">
            <div class="brand">Amoretti</div>
            <div class="brand-tagline">Pastelería Artesanal</div>
        </div>
        <div class="header-title-cell">
            <div class="report-name">Catálogo de Pasteles</div>
            <div class="report-date">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
        </div>
    </div>
    <div class="header-accent"></div>
</div>

<div class="filter-row">
    <div class="filter-label">Filtro</div>
    <div class="filter-value">
        @if($categoriaSeleccionada !== 'Todas las categorías')
            Categoría: <strong>{{ $categoriaSeleccionada }}</strong>
        @else
            <strong>Todas las categorías</strong> &mdash; reporte completo
        @endif
    </div>
</div>

@php
    $totalProductos   = $productos->count();
    $totalDisponibles = $productos->where('disponible', true)->count();
    $sinStock         = $productos->where('stock', 0)->count();
    $valorInventario  = $productos->sum(fn($p) => $p->precio * $p->stock);
@endphp

<div class="metrics-row">
    <div class="metric-col">
        <div class="metric-box">
            <div class="metric-top"><div class="metric-num">{{ $totalProductos }}</div></div>
            <div class="metric-bottom"><div class="metric-lbl">Total pasteles</div></div>
        </div>
    </div>
    <div class="metric-col">
        <div class="metric-box">
            <div class="metric-top"><div class="metric-num">{{ $totalDisponibles }}</div></div>
            <div class="metric-bottom"><div class="metric-lbl">Disponibles</div></div>
        </div>
    </div>
    <div class="metric-col">
        <div class="metric-box">
            <div class="metric-top"><div class="metric-num">{{ $sinStock }}</div></div>
            <div class="metric-bottom"><div class="metric-lbl">Sin stock</div></div>
        </div>
    </div>
    <div class="metric-col">
        <div class="metric-box">
            <div class="metric-top"><div class="metric-num">${{ number_format($valorInventario, 0) }}</div></div>
            <div class="metric-bottom"><div class="metric-lbl">Valor inventario</div></div>
        </div>
    </div>
</div>

@php $categoriaActual = null; $rowIndex = 0; @endphp

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th style="width:6%;">Img</th>
            <th style="width:22%;">Nombre del pastel</th>
            <th style="width:18%;">Sabor</th>
            <th style="width:13%;">Categoría</th>
            <th style="width:14%;">Tamaño</th>
            <th style="width:10%;" class="right">Precio</th>
            <th style="width:8%;" class="center">Stock</th>
            <th style="width:9%;" class="center">Activo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
            @if($categoriaActual !== $producto->categoria)
                @php $categoriaActual = $producto->categoria; $rowIndex = 0; @endphp
                <tr class="group-row">
                    <td colspan="8">
                        <span class="group-dot"></span>{{ $producto->categoria }}
                    </td>
                </tr>
            @endif
            @php $rowIndex++; $rowClass = $rowIndex % 2 === 0 ? 'data-even' : 'data-odd'; @endphp
            <tr class="{{ $rowClass }}">
                <td>
                    @php $ruta = public_path('storage/' . $producto->imagen); @endphp
                    @if($producto->imagen && file_exists($ruta))
                        <div class="thumb"><img src="{{ $ruta }}" alt="{{ $producto->nombre }}"></div>
                    @else
                        <div class="thumb-ph">—</div>
                    @endif
                </td>
                <td class="td-nombre">{{ $producto->nombre }}</td>
                <td class="td-sabor">{{ $producto->sabor }}</td>
                <td><span class="cat-pill">{{ $producto->categoria }}</span></td>
                <td style="color:#7a5a52;font-size:7.5pt;">{{ $producto->tamano }}</td>
                <td class="td-precio">${{ number_format($producto->precio, 0) }}</td>
                <td class="td-center">
                    @if($producto->stock > 10)
                        <span class="stock-ok">{{ $producto->stock }}</span>
                    @elseif($producto->stock > 0)
                        <span class="stock-low">{{ $producto->stock }}</span>
                    @else
                        <span class="stock-out">0</span>
                    @endif
                </td>
                <td class="td-center">
                    @if($producto->disponible)
                        <span class="st-on">&#10003;</span>
                    @else
                        <span class="st-off">&#10007;</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:20px;color:#7a5a52;font-style:italic;">
                    No hay productos con los filtros aplicados.
                </td>
            </tr>
        @endforelse

        @if($totalProductos > 0)
            <tr class="totals-row">
                <td colspan="5" style="font-size:7.5pt;color:rgba(255,220,210,0.75);">
                    {{ $totalProductos }} registros &middot; {{ $totalDisponibles }} disponibles &middot; {{ $sinStock }} sin stock
                </td>
                <td class="total-num">${{ number_format($valorInventario, 0) }}</td>
                <td colspan="2"></td>
            </tr>
        @endif
    </tbody>
</table>
</div>

<div class="footer">
    <div class="footer-left">
        <div class="footer-brand">Amoretti</div>
        <div>Pastelería Artesanal &middot; Documento de uso interno</div>
    </div>
    <div class="footer-right">
        <div class="footer-stamp">Confidencial</div>
    </div>
</div>

</body>
</html>
