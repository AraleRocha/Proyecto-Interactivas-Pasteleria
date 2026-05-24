<x-app-layout :title="auth()->user()->role === 'admin' ? 'Pedidos' : 'Mis pedidos'">

<style>
body { background: var(--surface); }

.ped-wrap { max-width: 1080px; margin: 0 auto; padding: 40px 32px 80px; }

.ped-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px,4vw,42px); font-weight: 700;
    color: var(--on-surface); margin: 0 0 6px;
}
.ped-sub { font-size: 15px; color: var(--on-surface-variant); margin-bottom: 36px; }

.flash {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 18px; border-radius: 12px; font-size: 14px; margin-bottom: 24px;
}
.flash.ok    { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
.flash.error { background:#fef2f2; border:1px solid #fecdd3; color:#991b1b; }

.borrador-banner {
    background: var(--surface-container-lowest);
    border: 2px dashed var(--outline-variant);
    border-radius: 20px; padding: 24px 28px;
    display: flex; justify-content: space-between; align-items: center;
    gap: 16px; flex-wrap: wrap; margin-bottom: 32px;
}
.borrador-left { display: flex; align-items: center; gap: 16px; }
.borrador-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--primary-fixed);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.borrador-icon .material-symbols-outlined { font-size: 26px; color: var(--primary); }
.borrador-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--primary); margin-bottom: 4px;
}
.borrador-total {
    font-family: 'Playfair Display', serif;
    font-size: 26px; font-weight: 700; color: var(--on-surface);
}
.borrador-meta { font-size: 13px; color: var(--on-surface-variant); margin-top: 2px; }

.ped-grid { display: grid; gap: 16px; }

.ped-card {
    background: var(--surface-container-lowest);
    border: 1px solid var(--outline-variant);
    border-radius: 20px; overflow: hidden;
    transition: box-shadow 0.2s;
}
.ped-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }

.ped-card-head {
    padding: 20px 24px;
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 12px; flex-wrap: wrap;
    border-bottom: 1px solid var(--surface-container);
}
.ped-id {
    font-size: 11px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--primary); margin-bottom: 4px;
}
.ped-total {
    font-family: 'Playfair Display', serif;
    font-size: 28px; font-weight: 700; color: var(--on-surface);
}
.ped-meta {
    display: flex; gap: 16px; flex-wrap: wrap;
    font-size: 13px; color: var(--on-surface-variant); margin-top: 6px;
}
.ped-meta span { display: flex; align-items: center; gap: 4px; }
.ped-meta .material-symbols-outlined { font-size: 14px; }

.estado-badge {
    padding: 8px 16px; border-radius: 9999px;
    font-size: 12px; font-weight: 700; white-space: nowrap;
    display: inline-flex; align-items: center; gap: 6px;
}
.estado-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.est-borrador   { background:#e0e7ff; color:#3730a3; } .est-borrador   .estado-dot { background:#4f46e5; }
.est-pendiente  { background:#fef3c7; color:#92400e; } .est-pendiente  .estado-dot { background:#f59e0b; }
.est-confirmado { background:#dbeafe; color:#1e40af; } .est-confirmado .estado-dot { background:#3b82f6; }
.est-por_confirmar { background:#ede9fe; color:#6d28d9; } .est-por_confirmar .estado-dot { background:#8b5cf6; }
.est-listo      { background:#d1fae5; color:#065f46; } .est-listo      .estado-dot { background:#10b981; }
.est-entregado  { background:#dcfce7; color:#166534; } .est-entregado  .estado-dot { background:#22c55e; }
.est-cancelado  { background:#fee2e2; color:#991b1b; } .est-cancelado  .estado-dot { background:#ef4444; }
.est-rechazado  { background:#fee2e2; color:#991b1b; } .est-rechazado  .estado-dot { background:#ef4444; }

.ped-card-body { padding: 16px 24px; display: flex; flex-direction: column; gap: 8px; }
.ped-mini-item {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 14px; color: var(--on-surface);
}
.ped-mini-item span { color: var(--on-surface-variant); font-size: 13px; }
.ped-mini-more { font-size: 12px; color: var(--on-surface-variant); font-style: italic; }

.ped-card-foot {
    padding: 14px 24px;
    border-top: 1px solid var(--surface-container);
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
}

.btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px; border-radius: 10px;
    background: var(--primary); color: #fff;
    font-size: 13px; font-weight: 700; text-decoration: none; border: none;
    cursor: pointer; transition: opacity 0.2s;
    box-shadow: 0 3px 10px rgba(151,49,0,0.2);
}
.btn-primary:hover { opacity: 0.88; }
.btn-ghost {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 20px; border-radius: 10px;
    background: var(--surface-container-high); color: var(--on-surface);
    font-size: 13px; font-weight: 700; text-decoration: none; border: none; cursor: pointer;
    transition: background 0.2s;
}
.btn-ghost:hover { background: var(--surface-container-highest); }

.ped-empty {
    padding: 72px 24px; text-align: center;
    background: var(--surface-container-lowest);
    border: 1px solid var(--outline-variant);
    border-radius: 20px; margin-top: 24px;
    color: var(--on-surface-variant);
}
.ped-empty .material-symbols-outlined { font-size: 52px; display: block; margin-bottom: 14px; opacity: 0.3; }
.ped-empty h2 { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--on-surface); margin-bottom: 8px; }

@media (max-width: 680px) {
    .ped-wrap { padding: 24px 16px 60px; }
    .borrador-banner { flex-direction: column; }
}
</style>

<div class="ped-wrap">

    <h1 class="ped-title">
        {{ auth()->user()->role === 'admin' ? 'Pedidos registrados' : 'Mis pedidos' }}
    </h1>
    <p class="ped-sub">
        {{ auth()->user()->role === 'admin'
            ? 'Gestiona todos los pedidos de clientes.'
            : 'Revisa el estado de tus pedidos o continúa uno en curso.' }}
    </p>

    @if(session('success'))
        <div class="flash ok">
            <span class="material-symbols-outlined" style="font-size:17px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flash error">
            <span class="material-symbols-outlined" style="font-size:17px;">error</span>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- borrador (cliente) --}}
    @if($pedidoBorrador)
        <div class="borrador-banner">
            <div class="borrador-left">
                <div class="borrador-icon">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
                <div>
                    <p class="borrador-label">Pedido en curso</p>
                    <p class="borrador-total">${{ number_format($pedidoBorrador->total, 0) }} MXN</p>
                    <p class="borrador-meta">
                        {{ $pedidoBorrador->productos->count() }} {{ $pedidoBorrador->productos->count() === 1 ? 'producto' : 'productos' }}
                        · Sin confirmar
                    </p>
                </div>
            </div>
            <a href="{{ route('client.pedidos.show', $pedidoBorrador) }}" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size:18px;">edit_note</span>
                Ver y finalizar pedido
            </a>
        </div>
    @endif

    {{-- lista  --}}
    @if($pedidos->count())
        <div class="ped-grid">
            @foreach($pedidos as $pedido)
                @if(auth()->user()->role === 'admin' || $pedido->estado !== 'borrador')
                    <div class="ped-card">
                        <div class="ped-card-head">
                            <div>
                                <p class="ped-id">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="ped-total">${{ number_format($pedido->total, 0) }} <small style="font-size:14px;font-weight:400;color:var(--on-surface-variant);font-family:inherit;">MXN</small></p>
                                <div class="ped-meta">
                                    <span>
                                        <span class="material-symbols-outlined">calendar_today</span>
                                        {{ $pedido->fecha_pedido->format('d/m/Y') }}
                                    </span>
                                    <span>
                                        <span class="material-symbols-outlined">local_shipping</span>
                                        Entrega: {{ $pedido->fecha_entrega ? $pedido->fecha_entrega->format('d/m/Y') : 'Sin fecha de entrega' }}
                                    </span>
                                    @if(auth()->user()->role === 'admin')
                                        <span>
                                            <span class="material-symbols-outlined">person</span>
                                            {{ $pedido->user->name }}
                                        </span>
                                    @endif
                                    @if($pedido->pago)
                                        <span>
                                            <span class="material-symbols-outlined">payments</span>
                                            {{ ucfirst($pedido->pago->metodo_pago) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="estado-badge est-{{ $pedido->estado }}">
                                <span class="estado-dot"></span>
                                {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                            </span>
                        </div>

                        {{-- Mini lista de productos (máx 3) --}}
                        <div class="ped-card-body">
                            @foreach($pedido->productos->take(3) as $item)
                                <div class="ped-mini-item">
                                    <strong>{{ $item->producto->nombre }}</strong>
                                    <span>×{{ $item->cantidad }} — ${{ number_format($item->subtotal, 0) }}</span>
                                </div>
                            @endforeach
                            @if($pedido->productos->count() > 3)
                                <p class="ped-mini-more">+ {{ $pedido->productos->count() - 3 }} más…</p>
                            @endif
                        </div>

                        <div class="ped-card-foot">
                            <a href="{{ route('client.pedidos.show', $pedido) }}" class="btn-primary">
                                <span class="material-symbols-outlined" style="font-size:16px;">visibility</span>
                                Ver detalle
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div style="margin-top:28px;">{{ $pedidos->links() }}</div>

    @else
        <div class="ped-empty">
            <span class="material-symbols-outlined">receipt_long</span>
            <h2>Aún no hay pedidos</h2>
            <p style="margin-bottom:20px;">Cuando realices un pedido aparecerá aquí.</p>
            <a href="{{ route('client.catalogo.index') }}" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size:17px;">storefront</span>
                Ir al catálogo
            </a>
        </div>
    @endif
</div>
    {{-- Chatbot --}}
    @include('components.chatbot')
</x-app-layout>