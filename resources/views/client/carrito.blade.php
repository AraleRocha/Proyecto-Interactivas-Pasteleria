<x-app-layout :title="__('Mi Carrito')">
<x-amo-styles />

<style>
body { background: var(--surface); }

.cart-wrap { max-width: 1080px; margin: 0 auto; padding: 40px 32px 80px; }

.cart-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--on-surface-variant); margin-bottom: 10px;
}
.cart-breadcrumb a { color: inherit; text-decoration: none; }
.cart-breadcrumb a:hover { color: var(--primary); }

.cart-title {
    font-family: 'Playfair Display', serif;
    font-size: 34px; font-weight: 700; color: var(--on-surface);
    margin: 0 0 4px;
}
.cart-subtitle { font-size: 15px; color: var(--on-surface-variant); margin-bottom: 36px; }

/* grid principal */
.cart-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px; align-items: start;
}

/* flash */
.cart-flash {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 18px; border-radius: 12px;
    font-size: 14px; margin-bottom: 20px;
}
.cart-flash.ok    { background: #ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
.cart-flash.error { background: #fef2f2; border:1px solid #fecdd3; color:#991b1b; }

/* card */
.cart-card {
    background: var(--surface-container-lowest);
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 0;
}
.cart-card-head {
    padding: 18px 24px;
    border-bottom: 1px solid var(--outline-variant);
    display: flex; justify-content: space-between; align-items: center;
}
.cart-card-head h2 {
    font-family: 'Playfair Display', serif;
    font-size: 19px; font-weight: 600; color: var(--on-surface);
}
.cart-vaciar-btn {
    font-size: 13px; color: var(--on-surface-variant);
    background: none; border: none; cursor: pointer;
    display: flex; align-items: center; gap: 4px; transition: color 0.2s;
}
.cart-vaciar-btn:hover { color: var(--error); }

/* ítem */
.cart-item {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    gap: 16px; align-items: center;
    padding: 18px 24px;
    border-bottom: 1px solid var(--surface-container);
    transition: background 0.15s;
}
.cart-item:last-child { border-bottom: none; }
.cart-item:hover { background: var(--surface-container-low); }

.cart-img {
    width: 80px; height: 80px; border-radius: 12px;
    overflow: hidden; background: var(--surface-container-low); flex-shrink: 0;
}
.cart-img img { width: 100%; height: 100%; object-fit: cover; }
.cart-img-ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: var(--on-surface-variant);
}

.cart-item-name {
    font-family: 'Playfair Display', serif;
    font-size: 16px; font-weight: 600; color: var(--on-surface);
    margin: 0 0 3px;
}
.cart-item-meta { font-size: 13px; color: var(--on-surface-variant); margin: 0 0 8px; }
.cart-item-fecha {
    font-size: 12px; color: var(--secondary);
    display: flex; align-items: center; gap: 4px;
}
.cart-item-notas {
    font-size: 12px; color: var(--on-surface-variant);
    font-style: italic; margin-top: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 340px;
}

.cart-item-right {
    display: flex; flex-direction: column; align-items: flex-end; gap: 10px; flex-shrink: 0;
}
.cart-item-price {
    font-family: 'Playfair Display', serif;
    font-size: 20px; font-weight: 700; color: var(--primary);
}
.cart-item-unit { font-size: 12px; color: var(--on-surface-variant); text-align: right; }

/* spinner cantidad */
.qty-row { display: flex; align-items: center; gap: 0; }
.qty-wrap {
    display: flex; align-items: center;
    border: 1.5px solid var(--outline-variant); border-radius: 10px; overflow: hidden;
}
.qty-btn {
    width: 32px; height: 32px;
    background: var(--surface-container-low); border: none; cursor: pointer;
    font-size: 16px; color: var(--on-surface-variant);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
}
.qty-btn:hover { background: var(--surface-container); }
.qty-num {
    width: 36px; text-align: center;
    border: none; border-left: 1.5px solid var(--outline-variant); border-right: 1.5px solid var(--outline-variant);
    font-size: 14px; font-weight: 700; color: var(--on-surface);
    background: var(--surface-container-lowest); height: 32px;
    -moz-appearance: textfield;
}
.qty-num::-webkit-outer-spin-button,
.qty-num::-webkit-inner-spin-button { -webkit-appearance: none; }

.cart-del-btn {
    background: none; border: none; cursor: pointer;
    font-size: 12px; color: var(--on-surface-variant);
    display: flex; align-items: center; gap: 3px; transition: color 0.2s;
}
.cart-del-btn:hover { color: var(--error); }

/* vacío */
.cart-empty {
    padding: 60px 24px; text-align: center; color: var(--on-surface-variant);
}
.cart-empty .material-symbols-outlined {
    font-size: 52px; display: block; margin-bottom: 14px; opacity: 0.3;
}

/* resumen */
.cart-summary {
    background: var(--surface-container-lowest);
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
    padding: 24px;
    position: sticky; top: 24px;
}
.cart-summary h2 {
    font-family: 'Playfair Display', serif;
    font-size: 19px; font-weight: 600; color: var(--on-surface);
    margin: 0 0 18px; padding-bottom: 14px; border-bottom: 1px solid var(--outline-variant);
}
.sum-row {
    display: flex; justify-content: space-between;
    font-size: 13px; color: var(--on-surface-variant); margin-bottom: 8px;
}
.sum-row.total {
    font-size: 16px; font-weight: 700; color: var(--on-surface);
    border-top: 1px solid var(--outline-variant); padding-top: 14px; margin-top: 4px;
}
.sum-row.total span:last-child {
    font-family: 'Playfair Display', serif; font-size: 22px; color: var(--primary);
}
.cart-checkout-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 14px;
    background: var(--primary); color: #fff;
    font-size: 14px; font-weight: 700; letter-spacing: 0.03em;
    border: none; border-radius: 12px; cursor: pointer;
    text-decoration: none; margin-top: 20px;
    box-shadow: 0 4px 14px rgba(151,49,0,0.25);
    transition: opacity 0.2s;
}
.cart-checkout-btn:hover { opacity: 0.88; }
.cart-checkout-btn[disabled] { opacity: 0.4; pointer-events: none; }

.cart-back {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-size: 13px; color: var(--on-surface-variant); text-decoration: none;
    margin-top: 12px; transition: color 0.2s;
}
.cart-back:hover { color: var(--primary); }

.trust-strip { margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--surface-container); }
.trust-item {
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; color: var(--on-surface-variant); margin-bottom: 8px;
}
.trust-item .material-symbols-outlined {
    font-size: 15px; color: var(--primary); opacity: 0.7;
    font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
}

@media (max-width: 800px) {
    .cart-grid { grid-template-columns: 1fr; }
    .cart-summary { position: static; }
    .cart-wrap { padding: 24px 16px 60px; }
    .cart-item { grid-template-columns: 68px 1fr; }
    .cart-item-right { grid-column: 1/-1; flex-direction: row; justify-content: space-between; }
}
</style>

<div class="cart-wrap">

    <nav class="cart-breadcrumb">
        <a href="{{ route('catalogo.index') }}">Catálogo</a>
        <span class="material-symbols-outlined" style="font-size:15px;">chevron_right</span>
        <span>Mi carrito</span>
    </nav>

    <h1 class="cart-title">Mi carrito</h1>
    <p class="cart-subtitle">
        @if(count($carrito) === 0)
            No tienes productos agregados.
        @else
            {{ count($carrito) }} {{ count($carrito) === 1 ? 'producto' : 'productos' }} en tu carrito
        @endif
    </p>

    @if(session('success'))
        <div class="cart-flash ok">
            <span class="material-symbols-outlined" style="font-size:17px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="cart-flash error">
            <span class="material-symbols-outlined" style="font-size:17px;">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="cart-grid">

        {{-- ── ÍTEMS ── --}}
        <div class="cart-card">
            <div class="cart-card-head">
                <h2>Productos</h2>
                @if(count($carrito))
                    <form method="POST" action="{{ route('carrito.vaciar') }}"
                          onsubmit="return confirm('¿Vaciar todo el carrito?')">
                        @csrf @method('DELETE')
                        <button class="cart-vaciar-btn">
                            <span class="material-symbols-outlined" style="font-size:16px;">delete_sweep</span>
                            Vaciar carrito
                        </button>
                    </form>
                @endif
            </div>

            @forelse($carrito as $item)
                <div class="cart-item">
                    <div class="cart-img">
                        @if($item['imagen'])
                            <img src="{{ asset('storage/'.$item['imagen']) }}" alt="{{ $item['nombre'] }}">
                        @else
                            <div class="cart-img-ph">
                                <span class="material-symbols-outlined" style="font-size:28px;opacity:0.35;">cake</span>
                            </div>
                        @endif
                    </div>

                    <div style="min-width:0;">
                        <p class="cart-item-name">{{ $item['nombre'] }}</p>
                        <p class="cart-item-meta">{{ $item['sabor'] }} · {{ $item['tamano'] }}</p>
                        @if($item['fecha_entrega'])
                            <p class="cart-item-fecha">
                                <span class="material-symbols-outlined" style="font-size:13px;">event</span>
                                Entrega: {{ \Carbon\Carbon::parse($item['fecha_entrega'])->translatedFormat('d \d\e F, Y') }}
                            </p>
                        @endif
                        @if($item['notas'])
                            <p class="cart-item-notas">{{ $item['notas'] }}</p>
                        @endif
                    </div>

                    <div class="cart-item-right">
                        <div>
                            <p class="cart-item-unit">${{ number_format($item['precio'],0) }} c/u</p>
                            <p class="cart-item-price">${{ number_format($item['subtotal'],0) }}</p>
                        </div>

                        <form method="POST" action="{{ route('carrito.actualizar', $item['producto_id']) }}"
                              id="form-{{ $item['producto_id'] }}">
                            @csrf @method('PATCH')
                            <div class="qty-wrap">
                                <button type="button" class="qty-btn"
                                        onclick="qty({{ $item['producto_id'] }}, -1)">−</button>
                                <input type="number" name="cantidad" class="qty-num"
                                       id="qty-{{ $item['producto_id'] }}"
                                       value="{{ $item['cantidad'] }}" min="1" max="99"
                                       onchange="document.getElementById('form-{{ $item['producto_id'] }}').submit()">
                                <button type="button" class="qty-btn"
                                        onclick="qty({{ $item['producto_id'] }}, 1)">+</button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('carrito.eliminar', $item['producto_id']) }}">
                            @csrf @method('DELETE')
                            <button class="cart-del-btn">
                                <span class="material-symbols-outlined" style="font-size:14px;">close</span>
                                Quitar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="cart-empty">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <p style="margin-bottom:20px;">Tu carrito está vacío</p>
                    <a href="{{ route('catalogo.index') }}" class="amo-btn-primary">
                        <span class="material-symbols-outlined" style="font-size:18px;">storefront</span>
                        Explorar catálogo
                    </a>
                </div>
            @endforelse
        </div>

        {{-- ── RESUMEN ── --}}
        <div class="cart-summary">
            <h2>Resumen</h2>

            @foreach($carrito as $item)
                <div class="sum-row">
                    <span>{{ $item['nombre'] }} ×{{ $item['cantidad'] }}</span>
                    <span>${{ number_format($item['subtotal'],0) }}</span>
                </div>
            @endforeach

            <div class="sum-row total">
                <span>Total</span>
                <span>${{ number_format($total,0) }} <small style="font-size:12px;color:var(--on-surface-variant);font-weight:400;">MXN</small></span>
            </div>

            @if(count($carrito))
                <a href="{{ route('pedidos.checkout') }}" class="cart-checkout-btn">
                    <span class="material-symbols-outlined" style="font-size:19px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">check_circle</span>
                    Confirmar pedido
                </a>
            @else
                <button class="cart-checkout-btn" disabled>Confirmar pedido</button>
            @endif

            <a href="{{ route('catalogo.index') }}" class="cart-back">
                <span class="material-symbols-outlined" style="font-size:15px;">arrow_back</span>
                Seguir comprando
            </a>

            <div class="trust-strip">
                <div class="trust-item"><span class="material-symbols-outlined">verified</span> Ingredientes naturales</div>
                <div class="trust-item"><span class="material-symbols-outlined">local_shipping</span> Entrega en SLP</div>
                <div class="trust-item"><span class="material-symbols-outlined">schedule</span> Anticipo mínimo 48 h</div>
            </div>
        </div>
    </div>
</div>

<script>
function qty(id, delta) {
    const input = document.getElementById('qty-' + id);
    input.value = Math.max(1, parseInt(input.value) + delta);
    document.getElementById('form-' + id).submit();
}
</script>
</x-app-layout>