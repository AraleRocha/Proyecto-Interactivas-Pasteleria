<x-app-layout title="Pedidos">
    <style>
        .adm-wrap{
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px;
        }

        .adm-head{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:16px;
            flex-wrap:wrap;
            margin-bottom:24px;
        }

        .adm-title{
            font-family:'Playfair Display', serif;
            font-size:clamp(28px,4vw,42px);
            font-weight:700;
            margin:0;
        }

        .adm-sub{
            color:var(--on-surface-variant);
            margin-top:6px;
        }

        .adm-card{
            background:var(--surface-container-low);
            border:1px solid var(--outline-variant);
            border-radius:24px;
            overflow:hidden;
        }

        .adm-table-wrap{
            overflow-x:auto;
        }

        .adm-table{
            width:100%;
            border-collapse:collapse;
            min-width:1100px;
        }

        .adm-table th,
        .adm-table td{
            padding:14px 16px;
            border-bottom:1px solid var(--outline-variant);
            text-align:left;
            vertical-align:top;
            font-size:14px;
        }

        .adm-table th{
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:var(--on-surface-variant);
            background:var(--surface-container-lowest);
        }

        .adm-id{
            font-weight:700;
            color:var(--primary);
        }

        .adm-client{
            font-weight:600;
        }

        .adm-items{
            display:flex;
            flex-direction:column;
            gap:6px;
        }

        .adm-item-line{
            font-size:13px;
            color:var(--on-surface-variant);
        }

        .adm-total{
            font-weight:700;
            color:var(--primary);
            white-space:nowrap;
        }

        .estado-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:8px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
            white-space:nowrap;
        }

        .est-borrador{ background:#e0e7ff; color:#3730a3; }
        .est-pendiente{ background:#fef3c7; color:#92400e; }
        .est-por_confirmar{ background:#dbeafe; color:#1e40af; }
        .est-horneando{ background:#ede9fe; color:#6d28d9; }
        .est-listo{ background:#dcfce7; color:#166534; }
        .est-rechazado{ background:#fee2e2; color:#991b1b; }
        .est-cancelado{ background:#fee2e2; color:#991b1b; }
        .est-entregado{ background:#dcfce7; color:#166534; }

        .btn-row{
            display:flex;
            flex-wrap:wrap;
            gap:8px;
        }

        .btn-soft,
        .btn-ok,
        .btn-no,
        .btn-detail{
            border:none;
            border-radius:12px;
            padding:10px 14px;
            font-weight:700;
            font-size:13px;
            cursor:pointer;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
            transition:all .2s ease;
            box-shadow:0 2px 8px rgba(0,0,0,.06);
        }

        .btn-detail{
            background:var(--surface-container-high);
            color:var(--on-surface);
            border:1px solid var(--outline-variant);
        }

        .btn-detail:hover{
            background:var(--surface-container-highest);
            transform:translateY(-1px);
        }

        .btn-ok{
            background:#dcfce7;
            color:#166534;
            border:1px solid #bbf7d0;
        }

        .btn-ok:hover{
            background:#bbf7d0;
            transform:translateY(-1px);
        }

        .btn-no{
            background:#fef2f2;
            color:#991b1b;
            border:1px solid #fecdd3;
        }

        .btn-no:hover{
            background:#fee2e2;
            transform:translateY(-1px);
        }

        .btn-soft{
            background:var(--primary-fixed);
            color:var(--primary);
            border:1px solid rgba(151,49,0,.12);
        }

        .btn-soft:hover{
            background:var(--primary-fixed-dim);
            transform:translateY(-1px);
        }

        .empty{
            padding:60px 20px;
            text-align:center;
            color:var(--on-surface-variant);
        }
    </style>

    <div class="adm-wrap">
        <div class="adm-head">
            <div>
                <h1 class="adm-title">Pedidos</h1>
                <p class="adm-sub">Administración de pedidos, pagos y estados.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="amo-flash-ok" style="margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($pedidos->count())
            <div class="adm-card">
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Entrega</th>
                                <th>Estado</th>
                                <th>Pago</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                                <tr>
                                    <td>
                                        <span class="adm-id">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>

                                    <td>
                                        <div class="adm-client">
                                            {{ $pedido->user->name ?? 'Sin cliente' }}
                                        </div>
                                        <div style="font-size:13px;color:var(--on-surface-variant);">
                                            {{ $pedido->user->email ?? '' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $pedido->fecha_pedido?->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        {{ $pedido->fecha_entrega?->format('d/m/Y') ?? '—' }}
                                    </td>

                                    <td>
                                        <span class="estado-badge est-{{ $pedido->estado }}">
                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($pedido->pago)
                                            <div class="adm-items">
                                                <div class="adm-item-line">
                                                    {{ ucfirst($pedido->pago->metodo_pago) }}
                                                </div>
                                                <div class="adm-item-line">
                                                    {{ ucfirst($pedido->pago->estado_pago) }}
                                                </div>
                                            </div>
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td>
                                        <div class="adm-items">
                                            @foreach($pedido->productos as $item)
                                                <div class="adm-item-line">
                                                    {{ $item->producto?->nombre ?? 'Producto eliminado' }}
                                                    × {{ $item->cantidad }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td>
                                        <span class="adm-total">
                                            ${{ number_format($pedido->total, 0) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;flex-wrap:wrap;">
                                            <a href="{{ route('admin.pedidos.show', $pedido) }}" class="amo-btn-edit">
                                                <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">visibility</span>
                                                Ver
                                            </a>

                                            @if($pedido->estado === 'por_confirmar')
                                                <form action="{{ route('admin.pedidos.aprobar', $pedido) }}"
                                                    method="POST"
                                                    style="margin:0;">
                                                    @csrf
                                                    <button type="submit" class="amo-btn-edit">
                                                        <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">check</span>
                                                        Aprobar
                                                    </button>
                                                </form>

                                                <form method="POST" style="margin:0;">
                                                    @csrf

                                                    <button type="button"
                                                        class="amo-btn-del"
                                                        onclick="prepararEliminacion(
                                                            '{{ route('admin.pedidos.rechazar', $pedido) }}',
                                                            '¿Rechazar este pedido?',
                                                            'POST'
                                                        )">

                                                        <span class="material-symbols-outlined"
                                                            style="font-size:15px;margin-right:4px;">
                                                            close
                                                        </span>

                                                        Rechazar
                                                    </button>
                                                </form>
                                            @endif

                                            @if($pedido->estado === 'horneando')
                                                <form action="{{ route('admin.pedidos.listo', $pedido) }}"
                                                    method="POST"
                                                    style="margin:0;">
                                                    @csrf
                                                    <button type="submit" class="amo-btn-edit">
                                                        <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">done_all</span>
                                                        Listo
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-top:24px;">
                {{ $pedidos->links() }}
            </div>
        @else
            <div class="adm-card empty">
                No hay pedidos para mostrar.
            </div>
        @endif
    </div>
</x-app-layout>

