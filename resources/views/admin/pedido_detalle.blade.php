<x-app-layout :title="'Pedido #' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT)">
<style>
body { background: var(--surface); }

.det-wrap { max-width: 1100px; margin: 0 auto; padding: 40px 32px 80px; }

.det-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--on-surface-variant);
    text-decoration: none; margin-bottom: 20px; transition: color 0.2s;
}
.det-back:hover { color: var(--primary); }

/* header */
.det-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 16px; flex-wrap: wrap; margin-bottom: 32px;
}
.det-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px,4vw,44px); font-weight: 700;
    color: var(--on-surface); margin: 0 0 6px;
}
.det-meta {
    font-size: 14px; color: var(--on-surface-variant);
    display: flex; flex-wrap: wrap; gap: 14px;
}
.det-meta span { display: flex; align-items: center; gap: 4px; }
.det-meta .material-symbols-outlined { font-size: 15px; }

/* estados */
.estado-badge {
    padding: 10px 18px; border-radius: 9999px;
    font-size: 13px; font-weight: 700;
    display: inline-flex; align-items: center; gap: 7px; white-space: nowrap;
}
.estado-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.est-borrador   { background:#e0e7ff; color:#3730a3; } .est-borrador   .estado-dot { background:#4f46e5; }
.est-pendiente  { background:#fef3c7; color:#92400e; } .est-pendiente  .estado-dot { background:#f59e0b; }
.est-confirmado { background:#dbeafe; color:#1e40af; } .est-confirmado .estado-dot { background:#3b82f6; }
.est-por_confirmar { background:#ede9fe; color:#6d28d9; } .est-por_confirmar .estado-dot { background:#8b5cf6; }
.est-listo      { background:#d1fae5; color:#065f46; } .est-listo      .estado-dot { background:#10b981; }
.est-entregado  { background:#dcfce7; color:#166534; } .est-entregado  .estado-dot { background:#22c55e; }
.est-cancelado  { background:#fee2e2; color:#991b1b; } .est-cancelado  .estado-dot { background:#ef4444; }

/* layout */
.det-grid { display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 24px; align-items: start; }

/* cards */
.det-card {
    background: var(--surface-container-lowest);
    border: 1px solid var(--outline-variant);
    border-radius: 20px; overflow: hidden; margin-bottom: 20px;
}
.det-card:last-child { margin-bottom: 0; }
.det-card-head {
    padding: 16px 22px; border-bottom: 1px solid var(--outline-variant);
    display: flex; align-items: center; gap: 10px;
}
.det-card-head h3 {
    font-family: 'Playfair Display', serif;
    font-size: 18px; font-weight: 600; color: var(--on-surface);
}
.det-card-head .material-symbols-outlined { font-size: 20px; color: var(--primary); }
.det-card-body { padding: 18px 22px; }

/* flash */
.flash {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 18px; border-radius: 12px; font-size: 14px; margin-bottom: 24px;
}
.flash.ok    { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
.flash.error { background:#fef2f2; border:1px solid #fecdd3; color:#991b1b; }

/* ítems */
.det-item {
    display: grid; grid-template-columns: 72px 1fr auto;
    gap: 14px; align-items: center;
    padding: 14px 0; border-bottom: 1px solid var(--surface-container);
}
.det-item:last-child { border-bottom: none; padding-bottom: 0; }

.det-item-img {
    width: 72px; height: 72px; border-radius: 12px;
    overflow: hidden; background: var(--surface-container-low); flex-shrink: 0;
}
.det-item-img img { width: 100%; height: 100%; object-fit: cover; }
.det-item-img-ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: var(--on-surface-variant);
}

.det-item-name  { font-weight: 600; font-size: 15px; color: var(--on-surface); margin-bottom: 3px; }
.det-item-meta  { font-size: 13px; color: var(--on-surface-variant); }
.det-item-price {
    font-family: 'Playfair Display', serif;
    font-weight: 700; font-size: 17px; color: var(--primary); white-space: nowrap;
}
.det-item-unit  { font-size: 12px; color: var(--on-surface-variant); text-align: right; }

.btn-edit-item {
    background: none; border: 1px solid var(--outline-variant);
    border-radius: 8px; padding: 5px 10px;
    font-size: 12px; font-weight: 600; color: var(--on-surface-variant);
    cursor: pointer; display: flex; align-items: center; gap: 4px;
    transition: all 0.2s; white-space: nowrap; margin-top: 8px;
}
.btn-edit-item:hover { border-color: var(--primary); color: var(--primary); }

/* resumen */
.sum-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 14px; color: var(--on-surface-variant); margin-bottom: 10px;
}
.sum-row strong { color: var(--on-surface); }
.sum-row.total {
    font-size: 17px; font-weight: 700; color: var(--on-surface);
    border-top: 1px solid var(--outline-variant); padding-top: 14px; margin-top: 6px;
}
.sum-row.total span:last-child {
    font-family: 'Playfair Display', serif; font-size: 26px; color: var(--primary);
}

/* campos form */
.fin-label {
    display: block; font-size: 12px; font-weight: 700;
    letter-spacing: 0.07em; text-transform: uppercase;
    color: var(--on-surface-variant); margin-bottom: 7px;
}
.fin-error { font-size: 12px; color: var(--error); margin-bottom: 12px; }

/* métodos de pago */
.pay-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-bottom: 20px; }
.pay-radio { display: none; }
.pay-label {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    padding: 14px 6px; border-radius: 12px;
    border: 1.5px solid var(--outline-variant);
    cursor: pointer; font-size: 12px; font-weight: 700;
    color: var(--on-surface-variant); text-align: center;
    background: var(--surface-container-low); transition: all 0.2s;
}
.pay-label .material-symbols-outlined {
    font-size: 24px; color: var(--on-surface-variant);
    font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
}
.pay-radio:checked + .pay-label {
    border-color: var(--primary); color: var(--primary);
    background: var(--primary-fixed);
    box-shadow: 0 0 0 3px rgba(151,49,0,0.08);
}
.pay-radio:checked + .pay-label .material-symbols-outlined { color: var(--primary); }

/* botones */
.btn-primary {
    width: 100%; padding: 14px; background: var(--primary); color: #fff;
    font-size: 14px; font-weight: 700; letter-spacing: 0.03em;
    border: none; border-radius: 12px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(151,49,0,0.25);
    transition: opacity 0.2s; font-family: inherit; text-decoration: none;
}
.btn-primary:hover { opacity: 0.88; }

.btn-danger {
    width: 100%; padding: 13px;
    background: #fef2f2; color: #991b1b;
    font-size: 14px; font-weight: 700;
    border: 1px solid #fecdd3; border-radius: 12px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.2s; font-family: inherit;
}
.btn-danger:hover { background: #fee2e2; }

/* info box */
.info-box {
    display: flex; gap: 10px; align-items: flex-start;
    padding: 12px 14px; background: var(--surface-container-low);
    border-radius: 10px; border: 1px solid var(--outline-variant); margin-bottom: 20px;
}
.info-box .material-symbols-outlined {
    font-size: 16px; color: var(--secondary); flex-shrink: 0; margin-top: 1px;
    font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
}
.info-box p { font-size: 13px; color: var(--on-surface-variant); line-height: 1.6; }

/* admin select */
.admin-select {
    display: block; width: 100%; padding: 12px 14px;
    background: var(--surface-container-low);
    border: 1.5px solid var(--outline-variant);
    border-radius: 10px; font-size: 14px; color: var(--on-surface);
    font-family: inherit; outline: none; margin-bottom: 14px;
    transition: border-color 0.2s;
}
.admin-select:focus { border-color: var(--primary); }

/* modal */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.55); backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center;
    z-index: 200; padding: 20px;
}
.modal-overlay.open { display: flex; }
.modal-box {
    width: 100%; max-width: 420px;
    background: var(--surface-container-lowest);
    border-radius: 20px; padding: 28px; position: relative;
}
.modal-handle {
    width: 36px; height: 4px; border-radius: 9999px;
    background: var(--outline-variant); margin: 0 auto 22px;
}
.modal-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700; color: var(--on-surface); margin: 0 0 4px;
}
.modal-sub { font-size: 14px; color: var(--on-surface-variant); margin-bottom: 20px; }
.modal-close {
    position: absolute; top: 16px; right: 20px;
    background: none; border: none; font-size: 22px;
    cursor: pointer; color: var(--on-surface-variant); line-height: 1;
}
.modal-input {
    display: block; width: 100%; padding: 12px 14px;
    background: var(--surface-container-low);
    border: 1.5px solid var(--outline-variant);
    border-radius: 10px; font-size: 15px; color: var(--on-surface);
    font-family: inherit; outline: none;
    transition: border-color 0.2s; margin-bottom: 16px;
}
.modal-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(151,49,0,0.08); }

/* timeline de estado */
.timeline {
    display: flex; align-items: center; gap: 0;
    margin-bottom: 24px; padding: 16px 20px;
    background: var(--surface-container-low);
    border-radius: 14px; overflow-x: auto;
}
.tl-step { display: flex; flex-direction: column; align-items: center; gap: 5px; flex-shrink: 0; }
.tl-dot {
    width: 28px; height: 28px; border-radius: 50%;
    border: 2px solid var(--outline-variant);
    background: var(--surface-container-lowest);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--on-surface-variant);
    transition: all 0.2s;
}
.tl-dot .material-symbols-outlined { font-size: 14px; }
.tl-dot.done  { background: var(--primary); border-color: var(--primary); color: #fff; }
.tl-dot.done .material-symbols-outlined { font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }
.tl-dot.current { border-color: var(--primary); color: var(--primary); }
.tl-label { font-size: 10px; font-weight: 700; letter-spacing: 0.05em; color: var(--on-surface-variant); text-align: center; }
.tl-label.done    { color: var(--primary); }
.tl-label.current { color: var(--primary); }
.tl-line { flex: 1; height: 2px; background: var(--outline-variant); min-width: 20px; }
.tl-line.done { background: var(--primary); }

@media (max-width: 860px) {
    .det-grid { grid-template-columns: 1fr; }
    .det-wrap { padding: 24px 16px 60px; }
    .pay-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="det-wrap">
    <a href="{{ route('admin.pedidos.index') }}" class="det-back">
        <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
        Volver a la lista de pedidos
    </a>

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

    <div class="det-header">
        <div>
            <h1 class="det-title">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <div class="det-meta">
                <span>
                    <span class="material-symbols-outlined">calendar_today</span>
                    {{ $pedido->fecha_pedido->format('d/m/Y H:i') }}
                </span>
                @if($pedido->fecha_entrega && !in_array($pedido->estado, ['borrador']))
                    <span>
                        <span class="material-symbols-outlined">local_shipping</span>
                        Entrega aprox.: {{ $pedido->fecha_entrega->format('d/m/Y') }}
                    </span>
                @endif
                @if(auth()->user()->role === 'admin' && $pedido->user)
                    <span>
                        <span class="material-symbols-outlined">person</span>
                        {{ $pedido->user->name }}
                    </span>
                @endif
            </div>
        </div>
        <span class="estado-badge est-{{ $pedido->estado }}">
            <span class="estado-dot"></span>
            {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
        </span>
    </div>

    {{-- estados (solo cliente, estados no cancelado) --}}
    @if(auth()->user()->role !== 'admin' && $pedido->estado !== 'cancelado')
        @php
            $pasos = [
                ['estado' => 'borrador', 'icon' => 'edit_note', 'label' => 'Borrador'],
                ['estado' => 'pendiente', 'icon' => 'schedule', 'label' => 'Pendiente'],
                ['estado' => 'por_confirmar', 'icon' => 'precision_manufacturing', 'label' => 'Por confirmar'],
                ['estado' => 'horneando', 'icon' => 'inventory', 'label' => 'Horneando'],
                ['estado' => 'listo',  'icon' => 'check_circle', 'label' => 'Listo'],
            ];
            $orden = array_column($pasos, 'estado');
            $currentIdx = array_search($pedido->estado, $orden) ?? 0;
        @endphp
        <div class="timeline">
            @foreach($pasos as $i => $paso)
                @php
                    $isDone    = $i < $currentIdx;
                    $isCurrent = $i === $currentIdx;
                @endphp
                @if($i > 0)
                    <div class="tl-line {{ $isDone ? 'done' : '' }}"></div>
                @endif
                <div class="tl-step">
                    <div class="tl-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
                        <span class="material-symbols-outlined">{{ $isDone ? 'check' : $paso['icon'] }}</span>
                    </div>
                    <span class="tl-label {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
                        {{ $paso['label'] }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="det-grid">
        {{--  productos  --}}
        <div>
            <div class="det-card">
                <div class="det-card-head">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <h3>Productos del pedido</h3>
                    {{-- Solo borrador puede agregar más --}}
                    @if($pedido->estado === 'borrador' && auth()->user()->role !== 'admin')
                        <a href="{{ route('client.catalogo.index') }}"
                           style="margin-left:auto;display:inline-flex;align-items:center;gap:5px;
                                  font-size:12px;font-weight:700;color:var(--primary);text-decoration:none;
                                  padding:6px 12px;border-radius:8px;border:1px solid var(--outline-variant);
                                  transition:background 0.15s;"
                           onmouseover="this.style.background='var(--primary-fixed)'"
                           onmouseout="this.style.background='transparent'">
                            <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                            Agregar más
                        </a>
                    @endif
                </div>
                <div class="det-card-body">
                    @forelse($pedido->productos as $item)
                        <div class="det-item">
                            <div class="det-item-img">
                                @if($item->producto?->imagen)
                                    <img src="{{ asset('storage/'.$item->producto->imagen) }}"
                                         alt="{{ $item->producto->nombre }}">
                                @else
                                    <div class="det-item-img-ph">
                                        <span class="material-symbols-outlined" style="font-size:26px;opacity:0.3;">cake</span>
                                    </div>
                                @endif
                            </div>

                            <div style="min-width:0;">
                                <p class="det-item-name">{{ $item->producto?->nombre ?? '—' }}</p>
                                <p class="det-item-meta">{{ $item->producto?->sabor }} · {{ $item->producto?->tamano }}</p>
                                <p class="det-item-meta" style="margin-top:4px;">
                                    Cantidad: <strong>{{ $item->cantidad }}</strong>
                                </p>
                            </div>

                            <div style="text-align:right;">
                                <p class="det-item-unit">${{ number_format($item->precio_unitario,0) }} c/u</p>
                                <p class="det-item-price">${{ number_format($item->subtotal,0) }}</p>

                                {{-- Editar solo en borrador --}}
                                @if($pedido->estado === 'borrador' && auth()->user()->role !== 'admin')
                                    <button class="btn-edit-item"
                                            onclick="abrirModal(this)"
                                            data-nombre="{{ $item->producto?->nombre }}"
                                            data-cantidad="{{ $item->cantidad }}"
                                            data-update="{{ route('client.pedido-items.update', $item) }}"
                                            data-delete="{{ route('client.pedido-items.destroy', $item) }}">
                                        <span class="material-symbols-outlined" style="font-size:14px;">edit</span>
                                        Editar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="padding:24px 0;text-align:center;color:var(--on-surface-variant);">
                            <span class="material-symbols-outlined" style="font-size:36px;opacity:0.25;display:block;margin-bottom:8px;">shopping_bag</span>
                            <p style="font-size:14px;">No hay productos en este pedido.</p>
                            @if($pedido->estado === 'borrador')
                                <a href="{{ route('client.catalogo.index') }}" class="btn-primary"
                                   style="margin-top:14px;width:auto;display:inline-flex;padding:10px 20px;">
                                    Ir al catálogo
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- derecha: resumen + acción --}}
        <div>

            {{-- Resumen --}}
            <div class="det-card">
                <div class="det-card-head">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <h3>Resumen</h3>
                </div>
                <div class="det-card-body">
                    @foreach($pedido->productos as $item)
                        <div class="sum-row">
                            <span>{{ $item->producto?->nombre }} ×{{ $item->cantidad }}</span>
                            <strong>${{ number_format($item->subtotal,0) }}</strong>
                        </div>
                    @endforeach
                    <div class="sum-row total">
                        <span>Total</span>
                        <span>${{ number_format($pedido->total,0) }} <small style="font-size:13px;color:var(--on-surface-variant);font-weight:400;">MXN</small></span>
                    </div>

                    @if($pedido->pago)
                        <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--outline-variant);
                                    display:flex;flex-direction:column;gap:8px;">
                            <div class="sum-row" style="margin:0;">
                                <span>Método de pago</span>
                                <strong>{{ ucfirst($pedido->pago->metodo_pago) }}</strong>
                            </div>
                            <div class="sum-row" style="margin:0;">
                                <span>Estado del pago</span>
                                <strong>{{ ucfirst($pedido->pago->estado_pago) }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Borrador: Confirmar pedido --}}
            @if($pedido->estado === 'borrador' && auth()->user()->role !== 'admin')
                <div class="det-card">
                    <div class="det-card-head">
                        <span class="material-symbols-outlined">send</span>
                        <h3>Confirmar pedido</h3>
                    </div>
                    <div class="det-card-body">

                        <div class="info-box">
                            <span class="material-symbols-outlined">schedule</span>
                            <p>Una vez confirmado, la fecha de entrega se asignará automáticamente. El pedido pasará a <strong>Pendiente</strong> donde podrás completar la compra.</p>
                        </div>

                        <form method="POST" action="{{ route('client.pedidos.confirmar', $pedido) }}">
                            @csrf

                            <label class="fin-label">Método de pago *</label>
                            <div class="pay-grid">
                                <div>
                                    <input type="radio" id="p-ef" name="metodo_pago"
                                           value="efectivo" class="pay-radio" checked>
                                    <label for="p-ef" class="pay-label">
                                        <span class="material-symbols-outlined">payments</span>
                                        Efectivo
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" id="p-ta" name="metodo_pago"
                                           value="tarjeta" class="pay-radio">
                                    <label for="p-ta" class="pay-label">
                                        <span class="material-symbols-outlined">credit_card</span>
                                        Tarjeta
                                    </label>
                                </div>
                            </div>
                            @error('metodo_pago')<p class="fin-error">{{ $message }}</p>@enderror

                            <button type="submit" class="btn-primary"
                                    {{ $pedido->productos->isEmpty() ? 'disabled style=opacity:.4;cursor:not-allowed;' : '' }}>
                                <span class="material-symbols-outlined" style="font-size:18px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">check_circle</span>
                                Confirmar pedido
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Pendiente: Comprar / Cancelar --}}
            @if($pedido->estado === 'pendiente' && auth()->user()->role !== 'admin')
                <div class="det-card">
                    <div class="det-card-head">
                        <span class="material-symbols-outlined">shopping_cart_checkout</span>
                        <h3>Completar compra</h3>
                    </div>
                    <div class="det-card-body" style="display:flex;flex-direction:column;gap:12px;">

                        <div class="info-box">
                            <span class="material-symbols-outlined">local_shipping</span>
                            <p>Al comprar, el stock se descontará y la fecha de entrega se confirmará a <strong>7 días</strong> desde hoy. Este paso es irreversible.</p>
                        </div>

                        <form method="POST" style="margin:0;">
                            @csrf

                            <button type="button"
                                class="btn-primary"
                                onclick="prepararEliminacion(
                                    '{{ route('client.pedidos.comprar', $pedido) }}',
                                    '¿Deseas completar la compra de este pedido?',
                                    'POST'
                                )">

                                <span class="material-symbols-outlined"
                                    style="font-size:18px;margin-right:4px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">
                                    shopping_cart_checkout
                                </span>

                                Comprar ahora
                            </button>
                        </form>

                        <form method="POST" style="margin:0;">
                            @csrf

                            <button type="button"
                                class="btn-danger"
                                onclick="prepararEliminacion(
                                    '{{ route('client.pedidos.cancelar', $pedido) }}',
                                    '¿Seguro que deseas cancelar este pedido?',
                                    'POST'
                                )">

                                <span class="material-symbols-outlined"
                                    style="font-size:17px;margin-right:4px;">
                                    cancel
                                </span>

                                Cancelar pedido
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- editar ítem (solo borrador) ── --}}
<div class="modal-overlay" id="modal-overlay" onclick="if(event.target===this)cerrarModal()">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal()">×</button>
        <div class="modal-handle"></div>
        <h3 class="modal-title">Editar producto</h3>
        <p class="modal-sub" id="modal-nombre" style="margin-bottom:20px;"></p>

        <form id="form-update" method="POST">
            @csrf @method('PATCH')
            <label class="fin-label">Nueva cantidad</label>
            <input type="number" id="modal-qty" name="cantidad"
                   class="modal-input" min="1" required>
            <button type="submit" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size:17px;">save</span>
                Guardar cambios
            </button>
        </form>

        <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--outline-variant);">
            <form id="form-delete" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')

                <button type="button"
                    class="btn-danger"
                    onclick="prepararEliminacion(
                        document.getElementById('form-delete').action,
                        '¿Eliminar este producto del pedido?',
                        'DELETE'
                    )">

                    <span class="material-symbols-outlined"
                        style="font-size:16px;margin-right:4px;">
                        delete
                    </span>

                    Eliminar del pedido
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModal(btn) {
    document.getElementById('modal-nombre').textContent = btn.dataset.nombre;
    document.getElementById('modal-qty').value          = btn.dataset.cantidad;
    document.getElementById('form-update').action       = btn.dataset.update;
    document.getElementById('form-delete').action       = btn.dataset.delete;
    document.getElementById('modal-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function cerrarModal() {
    document.getElementById('modal-overlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
</script>
</x-app-layout>