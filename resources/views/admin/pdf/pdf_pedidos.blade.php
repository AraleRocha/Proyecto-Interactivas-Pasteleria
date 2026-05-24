<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Pedidos — Amoretti</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.5pt;
            color: #1c1b1b;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #973100;
            color: #fff;
            padding: 14px 20px;
            margin-bottom: 16px;
        }
        .header-row { display: table; width: 100%; }
        .hl { display: table-cell; vertical-align: middle; }
        .hr { display: table-cell; vertical-align: middle; text-align: right; }
        .brand { font-size: 17pt; font-weight: bold; font-family: 'DejaVu Serif', serif; }
        .brand-sub { font-size: 7.5pt; opacity: 0.75; }
        .report-title { font-size: 12pt; font-weight: bold; }
        .report-meta  { font-size: 7.5pt; opacity: 0.8; margin-top: 2px; }

        /* ── Filtros banner ── */
        .filter-bar {
            background: #fff1ec; border: 1px solid #e1bfb4;
            border-radius: 5px; padding: 6px 12px;
            font-size: 8pt; color: #594139; margin-bottom: 12px;
        }
        .filter-bar strong { color: #973100; }

        /* ── Métricas ── */
        .metrics { display: table; width: 100%; margin-bottom: 14px; }
        .mc {
            display: table-cell; width: 25%; padding: 0 4px;
        }
        .mc-inner {
            background: #f6f3f2; border: 1px solid #e1bfb4;
            border-radius: 5px; padding: 8px 10px; text-align: center;
        }
        .mc-val { font-size: 16pt; font-weight: bold; color: #973100; font-family: 'DejaVu Serif', serif; }
        .mc-lbl { font-size: 7pt; color: #594139; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px; }

        /* ── Tabla ── */
        table.main { width: 100%; border-collapse: collapse; }
        table.main thead tr { background: #3d1f0d; color: #fff; }
        table.main thead th {
            padding: 8px 8px;
            font-size: 7.5pt; font-weight: bold;
            text-align: left; text-transform: uppercase; letter-spacing: 0.05em;
        }
        table.main tbody tr:nth-child(odd)  { background: #fff; }
        table.main tbody tr:nth-child(even) { background: #fdf8f4; }
        table.main tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #ede8e5;
            vertical-align: middle; font-size: 8pt;
        }

        .td-id    { font-weight: bold; color: #973100; }
        .td-name  { font-weight: bold; }
        .td-email { font-size: 7pt; color: #594139; }
        .td-total { font-weight: bold; color: #973100; font-family: 'DejaVu Serif', serif; font-size: 9pt; }

        /* estados (texto plano para compatibilidad DomPDF) */
        .est { font-weight: bold; font-size: 7.5pt; }
        .est-por_confirmar { color: #6d28d9; }
        .est-confirmado    { color: #1e40af; }
        .est-listo_recoger { color: #065f46; }
        .est-entregado     { color: #166534; }
        .est-rechazado,
        .est-cancelado     { color: #991b1b; }
        .est-pendiente     { color: #92400e; }

        /* totales */
        .totals-row td {
            background: #fff1ec;
            border-top: 2px solid #973100;
            font-weight: bold; padding: 8px;
            color: #3d1f0d; font-size: 8.5pt;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 16px; border-top: 1px solid #e1bfb4;
            padding-top: 6px; display: table; width: 100%;
        }
        .fl { display: table-cell; font-size: 7pt; color: #9e8880; }
        .fr { display: table-cell; text-align: right; font-size: 7pt; color: #9e8880; }

        @page { margin: 14mm 12mm 14mm 12mm; size: letter landscape; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-row">
            <div class="hl">
                <div class="brand">Amoretti</div>
                <div class="brand-sub">Pastelería Artesanal · San Luis Potosí</div>
            </div>
            <div class="hr">
                <div class="report-title">Reporte de Pedidos</div>
                <div class="report-meta">Generado: {{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- Filtros aplicados --}}
    <div class="filter-bar">
        Estado: <strong>{{ $filtros['estado'] }}</strong>
        &nbsp;·&nbsp; Desde: <strong>{{ $filtros['desde'] }}</strong>
        &nbsp;·&nbsp; Hasta: <strong>{{ $filtros['hasta'] }}</strong>
    </div>

    {{-- Métricas --}}
    @php
        $totalPedidos  = $pedidos->count();
        $totalMonto    = $pedidos->sum('total');
        $porConfirmar  = $pedidos->where('estado','por_confirmar')->count();
        $entregados    = $pedidos->where('estado','entregado')->count();
    @endphp

    <div class="metrics">
        <div class="mc"><div class="mc-inner">
            <div class="mc-val">{{ $totalPedidos }}</div>
            <div class="mc-lbl">Total pedidos</div>
        </div></div>
        <div class="mc"><div class="mc-inner">
            <div class="mc-val">${{ number_format($totalMonto,0) }}</div>
            <div class="mc-lbl">Facturación</div>
        </div></div>
        <div class="mc"><div class="mc-inner">
            <div class="mc-val">{{ $porConfirmar }}</div>
            <div class="mc-lbl">Por confirmar</div>
        </div></div>
        <div class="mc"><div class="mc-inner">
            <div class="mc-val">{{ $entregados }}</div>
            <div class="mc-lbl">Entregados</div>
        </div></div>
    </div>

    {{-- Tabla --}}
    <table class="main">
        <thead>
            <tr>
                <th style="width:7%;"># Pedido</th>
                <th style="width:14%;">Cliente</th>
                <th style="width:10%;">Fecha pedido</th>
                <th style="width:10%;">Fecha entrega</th>
                <th style="width:22%;">Productos</th>
                <th style="width:6%;">Uds.</th>
                <th style="width:9%;">Total</th>
                <th style="width:9%;">Método pago</th>
                <th style="width:13%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pedidos as $pedido)
                <tr>
                    <td class="td-id">#{{ str_pad($pedido->id,5,'0',STR_PAD_LEFT) }}</td>
                    <td>
                        <span class="td-name">{{ $pedido->user->name ?? '—' }}</span><br>
                        <span class="td-email">{{ $pedido->user->email ?? '' }}</span>
                    </td>
                    <td>{{ $pedido->fecha_pedido->format('d/m/Y') }}</td>
                    <td>{{ $pedido->fecha_entrega?->format('d/m/Y') ?? '—' }}</td>
                    <td style="font-size:7.5pt;color:#594139;">
                        {{ $pedido->productos->pluck('producto.nombre')->filter()->implode(', ') }}
                    </td>
                    <td style="text-align:center;">{{ $pedido->productos->sum('cantidad') }}</td>
                    <td class="td-total">${{ number_format($pedido->total,0) }}</td>
                    <td style="text-transform:capitalize;font-size:7.5pt;">
                        {{ $pedido->pago?->metodo_pago ?? '—' }}
                    </td>
                    <td>
                        <span class="est est-{{ $pedido->estado }}">
                            {{ ucfirst(str_replace('_',' ',$pedido->estado)) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:16px;color:#594139;">
                        No hay pedidos con los filtros aplicados.
                    </td>
                </tr>
            @endforelse

            {{-- Totales --}}
            @if($pedidos->count() > 0)
                <tr class="totals-row">
                    <td colspan="6" style="text-align:right;">Total facturado:</td>
                    <td>${{ number_format($totalMonto,0) }}</td>
                    <td colspan="2">{{ $totalPedidos }} pedidos</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <div class="fl">Amoretti Pastelería · Reporte confidencial · Solo para uso interno</div>
        <div class="fr">{{ now()->format('d \d\e F \d\e Y') }}</div>
    </div>

</body>
</html>